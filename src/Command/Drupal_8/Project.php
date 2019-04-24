<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:composer command.
 *
 * Inspired by drupal-composer/drupal-project.
 */
class Project extends BaseGenerator {

  protected $name = 'd8:project';
  protected $description = 'Generates a composer project';
  protected $alias = 'project';

  const DRUPAL_DEFAULT_VERSION = '~8.6.0';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $name_validator = function ($value) {
      if (!preg_match('#[^/]+/[^/]+$#i', $value)) {
        throw new \UnexpectedValueException('The value is not correct project name.');
      }
      return $value;
    };
    $questions['name'] = new Question('Project name (vendor/name)', FALSE);
    $questions['name']->setValidator($name_validator);

    $questions['description'] = new Question('Description');

    $questions['license'] = new Question('License', 'GPL-2.0-or-later');
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
    $questions['license']->setAutocompleterValues($licenses);

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
    $questions['document_root'] = new Question('Document root directory, type single dot to use Composer root', 'docroot');
    $questions['document_root']->setNormalizer(function ($value) {
      return $value == '.' ? '' : $value;
    });
    $questions['document_root']->setAutocompleterValues($document_roots);

    $questions['php'] = new Question('PHP version', '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);
    $questions['drupal'] = new Question('Drupal version', self::DRUPAL_DEFAULT_VERSION);
    $questions['drupal_core_strict'] = new ConfirmationQuestion('Would you like to get the same versions of Drupal core\'s dependencies as in Drupal core\'s composer.lock file?', FALSE);

    $this->collectVars($input, $output, $questions);

    $sections = ['require', 'require-dev'];

    $questions['drush'] = new ConfirmationQuestion('Would you like to install Drush?', TRUE);
    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['drush']) {
      $questions['drush_installation'] = new Question('Drush installation (require|require-dev)', 'require');
      $questions['drush_installation']->setValidator(Utils::getOptionsValidator($sections));
      $questions['drush_installation']->setAutocompleterValues($sections);
      $this->collectVars($input, $output, $questions);
    }

    $questions['drupal_console'] = new ConfirmationQuestion('Would you like to install Drupal Console?', !$vars['drush']);
    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['drupal_console']) {
      $questions['drupal_console_installation'] = new Question('Drupal Console installation (require|require-dev)', 'require-dev');
      $questions['drupal_console_installation']->setValidator(Utils::getOptionsValidator($sections));
      $questions['drupal_console_installation']->setAutocompleterValues($sections);
      $this->collectVars($input, $output, $questions);
    }

    $questions['composer_patches'] = new ConfirmationQuestion('Would you like to install Composer patches plugin?', TRUE);
    $questions['composer_merge'] = new ConfirmationQuestion('Would you like to install Composer merge plugin?', FALSE);
    $questions['behat'] = new ConfirmationQuestion('Would you like to create Behat tests?', FALSE);
    $questions['env'] = new ConfirmationQuestion('Would you like to load environment variables from .env files?', FALSE);
    $questions['asset_packagist'] = new ConfirmationQuestion('Would you like to add asset-packagist repository?', FALSE);

    $vars = &$this->collectVars($input, $output, $questions);

    $vars['document_root_path'] = $vars['document_root'] ?
      $vars['document_root'] . '/' : $vars['document_root'];

    $this->addFile('composer.json')
      ->content(self::buildComposerJson($vars));

    $this->addFile('.gitignore')
      ->template('d8/_project/gitignore.twig');

    $this->addFile('phpcs.xml')
      ->template('d8/_project/phpcs.xml.twig');

    $this->addFile('scripts/composer/create_required_files.php')
      ->template('d8/_project/scripts/composer/create_required_files.php.twig');

    if ($vars['behat']) {
      $this->addFile('tests/behat/behat.yml')
        ->template('d8/_project/tests/behat/behat.yml.twig');

      $this->addFile('tests/behat/local.behat.yml')
        ->template('d8/_project/tests/behat/local.behat.yml.twig');

      $this->addFile('tests/behat/bootstrap/BaseContext.php')
        ->template('d8/_project/tests/behat/bootstrap/BaseContext.php.twig');

      $this->addFile('tests/behat/bootstrap/ExampleContext.php')
        ->template('d8/_project/tests/behat/bootstrap/ExampleContext.php.twig');

      $this->addFile('tests/behat/features/example/user_forms.feature')
        ->template('d8/_project/tests/behat/features/example/user_forms.feature.twig');
    }

    if ($vars['env']) {
      $this->addFile('.env.example')
        ->template('d8/_project/env.example.twig');
      $this->addFile('load.environment.php')
        ->template('d8/_project/load.environment.php.twig');
    }

    if ($vars['document_root']) {
      $this->addDirectory('config/sync');
    }

    if ($vars['drush']) {
      $this->addFile('drush/drush.yml')
        ->template('d8/_project/drush/drush.yml.twig');
      $this->addFile('drush/Commands/PolicyCommands.php')
        ->template('d8/_project/drush/Commands/PolicyCommands.php.twig');
      $this->addFile('drush/sites/self.site.yml')
        ->template('d8/_project/drush/sites/self.site.yml.twig');
      $this->addFile('scripts/sync-site.sh')
        ->template('d8/_project/scripts/sync-site.sh.twig')
        ->mode(0544);
    }

    $this->addFile('patches/.keep')->content('');
    $this->addDirectory($vars['document_root_path'] . 'modules/contrib');
    $this->addDirectory($vars['document_root_path'] . 'modules/custom');
    $this->addDirectory($vars['document_root_path'] . 'modules/custom');
    $this->addDirectory($vars['document_root_path'] . 'libraries');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $result = parent::execute($input, $output);
    if ($result === 0) {
      $output->writeln(' <info>Next steps:</info>');
      $output->writeln(' <info>–––––––––––</info>');
      $output->writeln(' <info>1. Review generated files</info>');
      $output->writeln(' <info>2. Run <comment>composer install</comment> command</info>');
      $output->writeln(' <info>3. Install Drupal</info>');
      $output->writeln('');
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
    $composer_json['description'] = $vars['description'];
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
