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

  /**
   * Array of packages to check versions for.
   *
   * The key is package name and the value is allowable major version.
   */
  const PACKAGES = [
    'composer/installers' => '^1.8',
    'cweagans/composer-patches' => '^1.6',
    'drupal/core' => '^8.8',
    'drupal/core-composer-scaffold' => '^8.8',
    'drush/drush' => '^10.2',
    'oomphinc/composer-installers-extender' => '^1.1',
    'symfony/dotenv' => '^4.4',
    'drupal/core-recommended' => '^8.8',
    'drupal/core-dev' => '^8.8',
    'zaporylie/composer-drupal-optimizations' => '^1.1',
    'weitzman/drupal-test-traits' => '^1.3',
  ];

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $vars = &$this->vars;

    $name_validator = function (?string $value): ?string {
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
    $questions['document_root'] = new Question('Document root directory', 'docroot');
    $questions['document_root']->setAutocompleterValues($document_roots);

    $questions['php'] = new Question('PHP version', '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);

    $questions['drupal_core_recommended'] = new ConfirmationQuestion('Would you like to install recommended Drupal core dependencies?', FALSE);
    $questions['drupal_core_dev'] = new ConfirmationQuestion('Would you like to install Drupal core development dependencies?', FALSE);

    $questions['drush'] = new ConfirmationQuestion('Would you like to install Drush?');

    $questions['composer_patches'] = new ConfirmationQuestion('Would you like to install Composer patches plugin?');
    $questions['env'] = new ConfirmationQuestion('Would you like to load environment variables from .env files?', FALSE);
    $questions['asset_packagist'] = new ConfirmationQuestion('Would you like to add asset-packagist repository?', FALSE);

    $questions['tests'] = new ConfirmationQuestion('Would you like to create tests?', FALSE);

    $this->collectVars($input, $output, $questions);
    $vars['document_root_path'] = $vars['document_root'] . '/';
    if ($vars['tests']) {
      // @codingStandardsIgnoreStart
      [$vendor, $short_name] = explode('/', $vars['name']);
      $vars['namespace'] = Utils::camelize($vendor == $short_name ? $vendor : $vars['name']);
      // @codingStandardsIgnoreEnd
    }

    $this->addFile('composer.json')->content($this->buildComposerJson($vars));

    $this->addFile('.gitignore')
      ->template('d8/_project/gitignore.twig');
    $this->addFile('phpcs.xml')
      ->template('d8/_project/phpcs.xml.twig');

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
      $this->addFile('drush/Commands/PolicyCommands.php')
        ->template('d8/_project/drush/Commands/PolicyCommands.php.twig');
      $this->addFile('drush/sites/self.site.yml')
        ->template('d8/_project/drush/sites/self.site.yml.twig');
      $this->addFile('scripts/sync-site.sh')
        ->template('d8/_project/scripts/sync-site.sh.twig')
        ->mode(0544);
    }

    if ($vars['tests']) {
      $this->addFile('phpunit.xml')
        ->template('d8/_project/phpunit.xml.twig');
      $this->addFile('tests/src/HomePageTest.php')
        ->template('d8/_project/tests/src/HomePageTest.php.twig');
    }

    $this->addFile('patches/.keep')->content('');
    $this->addDirectory('{document_root}/modules/contrib');
    $this->addDirectory('{document_root}/modules/custom');
    $this->addDirectory('{document_root}/themes/custom');
    $this->addDirectory('{document_root}/libraries');
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
  protected function buildComposerJson(array $vars) {

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

    $this->addPackage($require, 'drupal/core-composer-scaffold');
    $this->addPackage($require, 'zaporylie/composer-drupal-optimizations');

    if ($vars['asset_packagist']) {
      $this->addPackage($require, 'oomphinc/composer-installers-extender');
    }

    if ($vars['drupal_core_recommended']) {
      $this->addPackage($require, 'drupal/core-recommended');
    }
    else {
      $this->addPackage($require, 'drupal/core');
      $this->addPackage($require, 'composer/installers');
    }

    if ($vars['drupal_core_dev']) {
      $this->addPackage($require_dev, 'drupal/core-dev');
    }

    if ($vars['drush']) {
      $this->addPackage($require, 'drush/drush');
    }

    if ($vars['composer_patches']) {
      $this->addPackage($require, 'cweagans/composer-patches');
    }

    if ($vars['env']) {
      $this->addPackage($require, 'symfony/dotenv');
      $composer_json['autoload']['files'][] = 'load.environment.php';
    }

    if ($vars['tests']) {
      $this->addPackage($require_dev, 'weitzman/drupal-test-traits');
      $composer_json['autoload-dev']['psr-4'][$vars['namespace'] . '\\Tests\\'] = 'tests/src';
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
    $composer_json['require-dev'] = (object) $require_dev;

    $composer_json['scripts']['phpcs'] = 'phpcs --standard=phpcs.xml';
    $composer_json['minimum-stability'] = 'dev';
    $composer_json['prefer-stable'] = TRUE;

    $composer_json['config'] = [
      'sort-packages' => TRUE,
      'bin-dir' => 'bin',
    ];

    if ($vars['composer_patches']) {
      $composer_json['extra']['composer-exit-on-patch-failure'] = TRUE;
    }

    $composer_json['extra']['drupal-scaffold']['locations']['web-root'] = $vars['document_root_path'];

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

    return json_encode($composer_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
  }

  /**
   * Requires a given package.
   *
   * @param array $section
   *   Section for the package (require|require-dev)
   * @param string $package
   *   A package to be added.
   */
  private function addPackage(array &$section, $package) {
    if (!array_key_exists($package, self::PACKAGES)) {
      throw new \InvalidArgumentException("Package $package is unknown.");
    }
    $section[$package] = self::PACKAGES[$package];
  }

}
