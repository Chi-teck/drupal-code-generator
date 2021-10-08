<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:permissions command.
 */
final class PermissionsTest extends BaseGeneratorTest {

  protected string $class = 'Yml\Permissions';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.permissions.yml' => '/_permissions.yml',
  ];

}
