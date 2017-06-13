<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:settings-local command.
 */
class SettingsLocalTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\SettingsLocal';

  /**
   * Test callback.
   */
  public function testGenerator() {

    $fixture_dir = __DIR__ . '/_settings_local';

    $this->answers = [
      'Override database configuration?' => TRUE,
      'Database name' => 'drupal_8',
      'Database username' => 'root',
      'Database password' => '123',
      'Database host' => 'localhost',
      'Database type' => 'mysql',
    ];
    $this->fixtures = [
      'settings.local.php' => $fixture_dir . '/_with_db_credentials.php',
    ];
    $this->doTest();

    $this->answers = [
      'Override database configuration?' => FALSE,
    ];
    $this->fixtures = [
      'settings.local.php' => $fixture_dir . '/_without_db_credentials.php',
    ];
    $this->doTest();

  }

}
