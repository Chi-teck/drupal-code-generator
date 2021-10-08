<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:install-file command.
 */
final class InstallFileTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\InstallFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'example.install' => '/_.install',
  ];

}
