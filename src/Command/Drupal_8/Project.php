<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\Generator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:composer command.
 *
 * Inspired by drupal-composer/drupal-project.
 */
class Project extends Generator {

  protected $name = 'd8:project';
  protected $description = 'Generates a composer project';
  protected $alias = 'project';

  const DRUPAL_DEFAULT_VERSION = '~8.7.0';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {

    $vars = &$this->vars;

    $name_validator = function ($value) {
      if (!preg_match('#[^/]+/[^/]+$#i', $value)) {
        throw new \UnexpectedValueException('The value is not correct project name.');
      }
      return $value;
    };
    $vars['name'] = $this->ask('Project name (vendor/name)', NULL, $name_validator);

    $vars['description'] = $this->ask('Description');

    $license_question = new Question('License', 'GPL-2.0-or-later');
    // @see https://getcomposer.org/doc/04-schema.md#license
    $licenses = [
      'Apache-2.0',
      'BSD-2-Clause',
      'BSD-3-Clause',
      'BSD-4-Clause',
      'GPL-2.0-only',
      'GPL-2.0-or-later',
      'GPL-3.0-only',
      'GPL-3.0-or-later',
      'LGPL-2.1-onl',
      'LGPL-2.1-or-later',
      'LGPL-3.0-only',
      'LGPL-3.0-or-later',
      'MIT',
      'proprietary',
    ];
    $license_question->setAutocompleterValues($licenses);
    $vars['license'] = $this->io->askQuestion($license_question);

    // Suggest most typical document roots.
    $document_roots = [
      'docroot',
      'web',
      'www',
      'public_html',
      'public',
      'htdocs',
      'httpdocs',
      'html',
    ];
    $document_root_question = new Question('Document root directory, type single dot to use Composer root', 'docroot');
    $document_root_question->setNormalizer(function ($value) {
      return $value == '.' ? '' : $value;
    });
    $document_root_question->setAutocompleterValues($document_roots);
    $vars['document_root'] = $this->io->askQuestion($document_root_question);

    $vars['php'] = $this->ask('PHP version', '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);
    $vars['drupal'] = $this->ask('Drupal version', self::DRUPAL_DEFAULT_VERSION);
    $vars['drupal_core_strict'] = $this->confirm('Would you like to get the same versions of Drupal core\'s dependencies as in Drupal core\'s composer.lock file?', FALSE);

    $sections = ['require', 'require-dev'];

    $vars['drush'] = $this->confirm('Would you like to install Drush?');
    if ($vars['drush']) {
      $drush_installation_question = new Question('Drush installation (require|require-dev)', 'require');
      $drush_installation_question->setValidator(Utils::getOptionsValidator($sections));
      $drush_installation_question->setAutocompleterValues($sections);
      $vars['drush_installation'] = $this->io->askQuestion($drush_installation_question);
    }

    $vars['drupal_console'] = $this->confirm('Would you like to install Drupal Console?', !$vars['drush']);
    if ($vars['drupal_console']) {
      $dc_installation_question = new Question('Drupal Console installation (require|require-dev)', 'require-dev');
      $dc_installation_question->setValidator(Utils::getOptionsValidator($sections));
      $dc_installation_question->setAutocompleterValues($sections);
      $vars['drupal_console_installation'] = $this->io->askQuestion($dc_installation_question);
    }

    $vars['composer_patches'] = $this->confirm('Would you like to install Composer patches plugin?');
    $vars['composer_merge'] = $this->confirm('Would you like to install Composer merge plugin?', FALSE);
    $vars['behat'] = $this->confirm('Would you like to create Behat tests?', FALSE);
    $vars['env'] = $this->confirm('Would you like to load environment variables from .env files?', FALSE);
    $vars['asset_packagist'] = $this->confirm('Would you like to add asset-packagist repository?', FALSE);

    $vars['document_root_path'] = $vars['document_root'] ?
      $vars['document_root'] . '/' : $vars['document_root'];

    $this->addFile('composer.json')
      ->content(self::buildComposerJson($vars));
    $this->addFile('.gitignore', 'd8/_project/gitignore');
    $this->addFile('phpcs.xml', 'd8/_project/phpcs.xml');
    $this->addFile('scripts/composer/create_required_files.php', 'd8/_project/scripts/composer/create_required_files.php');

    if ($vars['behat']) {
      $this->addFile('tests/behat/behat.yml', 'd8/_project/tests/behat/behat.yml');
      $this->addFile('tests/behat/local.behat.yml', 'd8/_project/tests/behat/local.behat.yml');
      $this->addFile('tests/behat/bootstrap/BaseContext.php', 'd8/_project/tests/behat/bootstrap/BaseContext.php');
      $this->addFile('tests/behat/bootstrap/ExampleContext.php', 'd8/_project/tests/behat/bootstrap/ExampleContext.php');
      $this->addFile('tests/behat/features/example/user_forms.feature', 'd8/_project/tests/behat/features/example/user_forms.feature');
    }

    if ($vars['env']) {
      $this->addFile('.env.example', 'd8/_project/env.example');
      $this->addFile('load.environment.php', 'd8/_project/load.environment.php');
    }

    if ($vars['document_root']) {
      $this->addDirectory('config/sync');
    }

    if ($vars['drush']) {
      $this->addFile('drush/drush.yml', 'd8/_project/drush/drush.yml');
      $this->addFile('drush/Commands/PolicyCommands.php', 'd8/_project/drush/Commands/PolicyCommands.php');
      $this->addFile('drush/sites/self.site.yml', 'd8/_project/drush/sites/self.site.yml');
      $this->addFile('scripts/sync-site.sh', 'd8/_project/scripts/sync-site.sh')->mode(0544);
    }

    $this->addFile('patches/.keep')->content('');
    $this->addDirectory('{document_root_path}modules/contrib');
    $this->addDirectory('{document_root_path}modules/custom');
    $this->addDirectory('{document_root_path}modules/custom');
    $this->addDirectory('{document_root_path}libraries');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) :int {
    $result = parent::execute($input, $output);
    if ($result === 0) {
      $message = [
        'Next steps:',
        '–––––––––––',
        '1. Review generated files',
        '2. Run <comment>composer install</comment> command',
        '3. Install Drupal',
      ];
      $this->io->text($message);
      $this->io->newLine();
    }
    return $result;
  }

  /**
   * Builds composer.json file.
   *
   * @param array $vars
   *   Collected variables.
   *
   * @return string
   *   Encoded JSON content.
   */
  protected static function buildComposerJson(array $vars) {

    $document_root_path = $vars['document_root_path'];

    $composer_json = [];

    $composer_json['name'] = $vars['name'];
    $composer_json['description'] = (string) $vars['description'];
    $composer_json['type'] = 'project';
    $composer_json['license'] = $vars['license'];

    $composer_json['repositories'][] = [
      'type' => 'composer',
      'url' => 'https://packages.drupal.org/8',
    ];
    if ($vars['asset_packagist']) {
      $composer_json['repositories'][] = [
        'type' => 'composer',
        'url' => 'https://asset-packagist.org',
      ];
    }

    $require = [];
    $require_dev = [];

    self::addPackage($require, 'drupal/core');
    $require['drupal/core'] = $vars['drupal'];
    self::addPackage($require, 'composer/installers');
    self::addPackage($require, 'drupal-composer/drupal-scaffold');
    self::addPackage($require, 'zaporylie/composer-drupal-optimizations');
    $require_dev['webflo/drupal-core-require-dev'] = $vars['drupal'];

    if ($vars['asset_packagist']) {
      self::addPackage($require, 'oomphinc/composer-installers-extender');
    }

    if ($vars['drupal_core_strict']) {
      $require['webflo/drupal-core-strict'] = $vars['drupal'];
    }

    if ($vars['drush']) {
      $vars['drush_installation'] == 'require'
        ? self::addPackage($require, 'drush/drush')
        : self::addPackage($require_dev, 'drush/drush');
    }

    if ($vars['drupal_console']) {
      $vars['drupal_console_installation'] == 'require'
        ? self::addPackage($require, 'drupal/console')
        : self::addPackage($require_dev, 'drupal/console');
    }

    if ($vars['composer_patches']) {
      self::addPackage($require, 'cweagans/composer-patches');
    }

    if ($vars['composer_merge']) {
      self::addPackage($require, 'wikimedia/composer-merge-plugin');
    }

    if ($vars['behat']) {
      // Behat and Mink drivers are Drupal core dev dependencies.
      self::addPackage($require_dev, 'drupal/drupal-extension');
    }

    if ($vars['env']) {
      self::addPackage($require, 'symfony/dotenv');
    }

    $composer_json['require'] = [
      'php' => $vars['php'],
      'ext-curl' => '*',
      'ext-gd' => '*',
      'ext-json' => '*',
    ];
    ksort($require);
    $composer_json['require'] += $require;

    ksort($require_dev);
    $composer_json['require-dev'] = $require_dev;

    // PHPUnit is core dev dependency.
    $composer_json['scripts']['phpunit'] = 'phpunit --colors=always --configuration ' . $document_root_path . 'core ' . $document_root_path . 'modules/custom';
    if ($vars['behat']) {
      $composer_json['scripts']['behat'] = 'behat --colors --config=tests/behat/local.behat.yml';
    }
    $composer_json['scripts']['phpcs'] = 'phpcs --standard=phpcs.xml';
    $composer_json['scripts']['post-install-cmd'][] = '@php ./scripts/composer/create_required_files.php';
    $composer_json['scripts']['post-update-cmd'][] = '@php ./scripts/composer/create_required_files.php';

    $composer_json['minimum-stability'] = 'dev';
    $composer_json['prefer-stable'] = TRUE;

    $composer_json['config'] = [
      'sort-packages' => TRUE,
      'bin-dir' => 'bin',
    ];

    if ($vars['env']) {
      $composer_json['autoload']['files'][] = 'load.environment.php';
    }

    if ($vars['composer_patches']) {
      $composer_json['extra']['composer-exit-on-patch-failure'] = TRUE;
    }

    if ($vars['asset_packagist']) {
      $composer_json['extra']['installer-types'] = [
        'bower-asset',
        'npm-asset',
      ];
    }
    $composer_json['extra']['installer-paths'] = [
      $document_root_path . 'core' => ['type:drupal-core'],
      $document_root_path . 'libraries/{$name}' => ['type:drupal-library'],
      $document_root_path . 'modules/contrib/{$name}' => ['type:drupal-module'],
      $document_root_path . 'themes/{$name}' => ['type:drupal-theme'],
      'drush/{$name}' => ['type:drupal-drush'],
    ];
    if ($vars['asset_packagist']) {
      $composer_json['extra']['installer-paths'][$document_root_path . 'libraries/{$name}'][] = 'type:bower-asset';
      $composer_json['extra']['installer-paths'][$document_root_path . 'libraries/{$name}'][] = 'type:npm-asset';
    }

    $composer_json['extra']['drupal-scaffold']['excludes'] = [
      '.csslintrc',
      '.editorconfig',
      '.eslintignore',
      '.eslintrc.json',
      '.gitattributes',
      '.ht.router.php',
      '.htaccess',
      'robots.txt',
      'update.php',
      'web.config',
    ];
    // Initial files are created but never updated.
    $composer_json['extra']['drupal-scaffold']['initial'] = [
      '.htaccess' => '.htaccess',
      'robots.txt' => 'robots.txt',
    ];

    // Move these files to Composer root.
    if ($vars['document_root']) {
      $composer_json['extra']['drupal-scaffold']['initial']['.editorconfig'] = '../.editorconfig';
      $composer_json['extra']['drupal-scaffold']['initial']['.gitattributes'] = '../.gitattributes';
    }
    ksort($composer_json['extra']['drupal-scaffold']['initial']);

    if ($vars['composer_merge']) {
      $composer_json['extra']['merge-plugin'] = [
        'include' => [
          $document_root_path . 'modules/custom/*/composer.json',
        ],
        'recurse' => TRUE,
      ];
    }

    return json_encode($composer_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
  }

  /**
   * Requires a given package.
   *
   * @param array $section
   *   Section for the package (require|require-dev)
   * @param string $package
   *   A package to be added.
   *
   * @todo Find a way to track versions automatically.
   */
  protected static function addPackage(array &$section, $package) {
    $versions = [
      'composer/installers' => '^1.4',
      'cweagans/composer-patches' => '^1.6',
      'drupal-composer/drupal-scaffold' => '^2.5',
      'drupal/console' => '^1.0',
      'drupal/core' => self::DRUPAL_DEFAULT_VERSION,
      'drupal/drupal-extension' => '^3.4',
      'drush/drush' => '^9.6',
      'oomphinc/composer-installers-extender' => '^1.1',
      'symfony/dotenv' => '^3.4',
      'webflo/drupal-core-require-dev' => self::DRUPAL_DEFAULT_VERSION,
      'webflo/drupal-core-strict' => self::DRUPAL_DEFAULT_VERSION,
      'wikimedia/composer-merge-plugin' => '^1.4',
      'zaporylie/composer-drupal-optimizations' => '^1.1',
    ];
    $section[$package] = $versions[$package];
  }

}
