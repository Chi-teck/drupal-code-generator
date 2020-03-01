<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:project command.
 */
final class ProjectTest extends BaseGeneratorTest {

  protected $class = 'Misc\Project';

  /**
   * Test callback.
   */
  public function testLight(): void {

    $default_php_version = '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;
    $interaction = [
      'Project name (vendor/name):' => 'example/foo',
      'Description:' => '',
      'License [GPL-2.0-or-later]:' => '',
      'Document root directory [docroot]:' => 'docroot',
      "PHP version [$default_php_version]:" => '>=7.3',
      'Would you like to install recommended Drupal core dependencies? [No]:' => 'No',
      'Would you like to install Drupal core development dependencies? [No]:' => 'No',
      'Would you like to install Drush? [Yes]:' => 'No',
      'Would you like to install Composer patches plugin? [Yes]:' => 'No',
      'Would you like to load environment variables from .env files? [No]:' => 'No',
      'Would you like to add asset-packagist repository? [No]:' => 'No',
      'Would you like to create tests? [No]:' => 'No',
    ];

    $path = '/_project/_light/';
    $fixtures = [
      'config/sync' => [],
      'docroot/libraries' => [],
      'docroot/modules/contrib' => [],
      'docroot/modules/custom' => [],
      'docroot/themes/custom' => [],
      '.gitignore' => $path . 'gitignore',
      'composer.json' => $path . 'composer.json',
      'phpcs.xml' => $path . 'phpcs.xml',
      'patches/.keep' => $path . 'patches/keep',
    ];

    parent::doTest($interaction, $fixtures);
  }

  /**
   * Test callback.
   */
  public function testFull(): void {

    $default_php_version = '>=' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;
    $interaction = [
      'Project name (vendor/name):' => 'example/foo',
      'Description:' => '',
      'License [GPL-2.0-or-later]:' => '',
      'Document root directory [docroot]:' => 'web',
      "PHP version [$default_php_version]:" => '>=7.3',
      'Would you like to install recommended Drupal core dependencies? [No]:' => 'Yes',
      'Would you like to install Drupal core development dependencies? [No]:' => 'Yes',
      'Would you like to install Drush? [Yes]:' => 'Yes',
      'Would you like to install Composer patches plugin? [Yes]:' => 'Yes',
      'Would you like to load environment variables from .env files? [No]:' => 'Yes',
      'Would you like to add asset-packagist repository? [No]:' => 'Yes',
      'Would you like to create tests? [No]:' => 'Yes',
    ];

    $path = '/_project/_full/';
    $fixtures = [
      'config/sync' => [],
      'web/libraries' => [],
      'web/modules/contrib' => [],
      'web/modules/custom' => [],
      'web/themes/custom' => [],
      '.env.example' => $path . 'env.example',
      '.gitignore' => $path . 'gitignore',
      'composer.json' => $path . 'composer.json',
      'load.environment.php' => $path . 'load.environment.php',
      'phpcs.xml' => $path . 'phpcs.xml',
      'phpunit.xml' => $path . 'phpunit.xml',
      'patches/.keep' => $path . 'patches/keep',
      'scripts/sync-site.sh' => $path . 'scripts/sync-site.sh',
      'drush/Commands/PolicyCommands.php' => $path . 'drush/Commands/PolicyCommands.php',
      'drush/sites/self.site.yml' => $path . 'drush/sites/self.site.yml',
      'tests/src/HomePageTest.php' => $path . 'tests/src/HomePageTest.php',
    ];

    parent::doTest($interaction, $fixtures);
  }

  /**
   * {@inheritdoc}
   */
  protected function processExpectedDisplay(string $display): string {
    $first_question = ' Project name (vendor/name):';
    $progress = " Checking packages........\e[2K\n";
    $display = str_replace("\n" . $first_question, $progress . $first_question, $display);
    $display .= " Next steps:\n";
    $display .= " –––––––––––\n";
    $display .= " 1. Review generated files\n";
    $display .= " 2. Run composer install command\n";
    $display .= " 3. Install Drupal\n\n";
    return $display;
  }

}
