<?php

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Command\Generator;
use DrupalCodeGenerator\Exception\RuntimeException;
use DrupalCodeGenerator\Utils;
use InvalidArgumentException;
use Symfony\Component\Console\Question\Question;

/**
 * Implements misc:project command.
 *
 * Inspired by drupal-composer/drupal-project.
 */
final class Project extends Generator {

  protected $name = 'misc:project';
  protected $description = 'Generates a composer project';
  protected $alias = 'project';

  /**
   * Array of packages to check versions for.
   *
   * The key is package name and the value is allowable major version.
   */
  private const PACKAGES = [
    'composer/installers' => 1,
    'cweagans/composer-patches' => 1,
    'drupal/core' => 8,
    'drupal/core-composer-scaffold' => 'drupal/core',
    'drush/drush' => 10,
    'oomphinc/composer-installers-extender' => 1,
    'symfony/dotenv' => 4,
    'drupal/core-recommended' => 'drupal/core',
    'drupal/core-dev' => 'drupal/core',
    'zaporylie/composer-drupal-optimizations' => 1,
    'weitzman/drupal-test-traits' => 1,
  ];

  /**
   * Versions of used packages.
   *
   * @var array
   */
  private $versions = [];

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {

    $this->loadPackages();

    $vars = &$this->vars;

    $name_validator = function (?string $value): ?string {
      $value = self::validateRequired($value);
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
    $document_root_question = new Question('Document root directory', 'docroot');
    $document_root_question->setAutocompleterValues($document_roots);
    $vars['document_root'] = $this->io->askQuestion($document_root_question);
    $vars['document_root_path'] = $vars['document_root'] . '/';

    $vars['php'] = $this->ask('PHP version', '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);

    $vars['drupal_core_recommended'] = $this->confirm('Would you like to install recommended Drupal core dependencies?', FALSE);
    $vars['drupal_core_dev'] = $this->confirm('Would you like to install Drupal core development dependencies?', FALSE);

    $vars['drush'] = $this->confirm('Would you like to install Drush?');

    $vars['composer_patches'] = $this->confirm('Would you like to install Composer patches plugin?');
    $vars['env'] = $this->confirm('Would you like to load environment variables from .env files?', FALSE);
    $vars['asset_packagist'] = $this->confirm('Would you like to add asset-packagist repository?', FALSE);

    $vars['tests'] = $this->confirm('Would you like to create tests?', FALSE);
    if ($vars['tests']) {
      // @codingStandardsIgnoreStart
      [$vendor, $short_name] = explode('/', $vars['name']);
      $vars['namespace'] = Utils::camelize($vendor == $short_name ? $vendor : $vars['name']);
      // @codingStandardsIgnoreEnd
    }

    $this->addFile('composer.json')->content($this->buildComposerJson($vars));

    $this->addFile('.gitignore', 'gitignore');
    $this->addFile('phpcs.xml', 'phpcs.xml');

    if ($vars['env']) {
      $this->addFile('.env.example', 'env.example');
      $this->addFile('load.environment.php', 'load.environment.php');
    }

    if ($vars['document_root']) {
      $this->addDirectory('config/sync');
    }

    if ($vars['drush']) {
      $this->addFile('drush/Commands/PolicyCommands.php', 'drush/Commands/PolicyCommands.php');
      $this->addFile('drush/sites/self.site.yml', 'drush/sites/self.site.yml');
      $this->addFile('scripts/sync-site.sh', 'scripts/sync-site.sh')->mode(0544);
    }

    if ($vars['tests']) {
      $this->addFile('phpunit.xml', 'phpunit.xml');
      $this->addFile('tests/src/HomePageTest.php', 'tests/src/HomePageTest.php');
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
  protected function printSummary(AssetCollection $dumped_assets): void {
    parent::printSummary($dumped_assets);

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

  /**
   * Builds composer.json file.
   *
   * @param array $vars
   *   Collected variables.
   *
   * @return string
   *   Encoded JSON content.
   */
  private function buildComposerJson(array $vars): string {

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

    if ($vars['env']) {
      $composer_json['autoload']['files'][] = 'load.environment.php';
    }

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
  private function addPackage(array &$section, $package): void {
    if (!array_key_exists($package, $this->versions)) {
      throw new InvalidArgumentException("Package $package is unknown.");
    }
    $section[$package] = $this->versions[$package];
  }

  /**
   * Loads composer packages.
   */
  private function loadPackages(): void {
    $this->io->getErrorStyle()->write(' <comment>Checking packages</comment>');
    foreach (self::PACKAGES as $package => $major_version) {
      if ($major_version == 'drupal/core') {
        $this->versions[$package] = $this->versions[$major_version];
        continue;
      }
      $this->versions[$package] = self::getPackageVersion($package, $major_version);
      $this->io->getErrorStyle()->write('<comment>.</comment>');
    }
    $this->io->getErrorStyle()->write("\x1B[2K");
  }

  /**
   * Returns the highest stable version of a given package.
   */
  private static function getPackageVersion(string $package, int $major_version): string {
    $url = "https://packagist.org/packages/$package.json";
    if (!$data_encoded = @file_get_contents($url)) {
      throw new RuntimeException(sprintf('Could not load package information from %s.', $url));
    }
    $data = @json_decode($data_encoded, JSON_OBJECT_AS_ARRAY);
    if (!isset($data['package']['versions'])) {
      throw new RuntimeException(sprintf('Could not decode JSON from %s.', $url));
    }
    // Some packages have versions prefixed with 'v'.
    $all_versions = preg_replace('/^v?/', '', array_keys($data['package']['versions']));
    $stable_versions = preg_grep(sprintf('/^%d\.\d+\.\d+$/', $major_version), $all_versions);
    if (count($stable_versions) == 0) {
      throw new RuntimeException(sprintf('Could not find an appropriate version of %s package.', $package));
    }
    usort($stable_versions, 'version_compare');
    return '^' . preg_replace('/\.\d+$/', '', end($stable_versions));
  }

}
