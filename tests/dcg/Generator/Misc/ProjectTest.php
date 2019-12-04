<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:project command.
 */
class ProjectTest extends BaseGeneratorTest {

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
      'Document root directory, type single dot to use Composer root [docroot]:' => '.',
      "PHP version [$default_php_version]:" => '>=7.3',
      'Drupal version [~8.7.0]:' => '^8.6.5',
      'Would you like to get the same versions of Drupal core\'s dependencies as in Drupal core\'s composer.lock file? [No]:' => 'No',
      'Would you like to install Drush? [Yes]:' => 'No',
      'Would you like to install Drupal Console? [Yes]:' => 'No',
      'Would you like to install Composer patches plugin? [Yes]:' => 'No',
      'Would you like to install Composer merge plugin? [No]:' => 'No',
      'Would you like to create Behat tests? [No]:' => 'No',
      'Would you like to load environment variables from .env files? [No]:' => 'No',
      'Would you like to add asset-packagist repository? [No]:' => 'No',
    ];

    $path = '/_project/_light/';
    $fixtures = [
      'libraries' => [],
      'modules/contrib' => [],
      'modules/custom' => [],
      '.gitignore' => $path . 'gitignore',
      'composer.json' => $path . 'composer.json',
      'phpcs.xml' => $path . 'phpcs.xml',
      'patches/.keep' => $path . 'patches/keep',
      'scripts/composer/create_required_files.php' => $path . 'scripts/composer/create_required_files.php',
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
      'License [GPL-2.0-or-later]:' => 'GPL-2.0-or-later',
      'Document root directory, type single dot to use Composer root [docroot]:' => 'web',
      "PHP version [$default_php_version]:" => '>=7.3',
      'Drupal version [~8.7.0]:' => '^8.6.5',
      'Would you like to get the same versions of Drupal core\'s dependencies as in Drupal core\'s composer.lock file? [No]:' => 'Yes',
      'Would you like to install Drush? [Yes]:' => 'Yes',
      'Drush installation (require|require-dev) [require]:' => 'require-dev',
      'Would you like to install Drupal Console? [No]:' => 'Yes',
      'Drupal Console installation (require|require-dev) [require-dev]:' => 'require-dev',
      'Would you like to install Composer patches plugin? [Yes]:' => 'Yes',
      'Would you like to install Composer merge plugin? [No]:' => 'Yes',
      'Would you like to create Behat tests? [No]:' => 'Yes',
      'Would you like to load environment variables from .env files? [No]:' => 'Yes',
      'Would you like to add asset-packagist repository? [No]:' => 'Yes',
    ];

    $path = '/_project/_full/';
    $fixtures = [
      'config/sync' => [],
      'web/libraries' => [],
      'web/modules/contrib' => [],
      'web/modules/custom' => [],
      '.env.example' => $path . 'env.example',
      '.gitignore' => $path . 'gitignore',
      'composer.json' => $path . 'composer.json',
      'load.environment.php' => $path . 'load.environment.php',
      'phpcs.xml' => $path . 'phpcs.xml',
      'drush/drush.yml' => $path . 'drush/drush.yml',
      'patches/.keep' => $path . 'patches/keep',
      'scripts/sync-site.sh' => $path . 'scripts/sync-site.sh',
      'drush/Commands/PolicyCommands.php' => $path . 'drush/Commands/PolicyCommands.php',
      'drush/sites/self.site.yml' => $path . 'drush/sites/self.site.yml',
      'scripts/composer/create_required_files.php' => $path . 'scripts/composer/create_required_files.php',
      'tests/behat/behat.yml' => $path . 'tests/behat/behat.yml',
      'tests/behat/bootstrap/BaseContext.php' => $path . 'tests/behat/bootstrap/BaseContext.php',
      'tests/behat/bootstrap/ExampleContext.php' => $path . 'tests/behat/bootstrap/ExampleContext.php',
      'tests/behat/features/example/user_forms.feature' => $path . 'tests/behat/features/example/user_forms.feature',
      'tests/behat/local.behat.yml' => $path . 'tests/behat/local.behat.yml',
    ];

    parent::doTest($interaction, $fixtures);
  }

  /**
   * {@inheritdoc}
   */
  protected function processExpectedDisplay(string $display): string {
    $display .= " Next steps:\n";
    $display .= " –––––––––––\n";
    $display .= " 1. Review generated files\n";
    $display .= " 2. Run composer install command\n";
    $display .= " 3. Install Drupal\n\n";
    return $display;
  }

}
