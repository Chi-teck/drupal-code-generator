<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:links:task command.
 */
class TaskLinksTest extends BaseGeneratorTest {

  protected string $class = 'Yml\Links\Task';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.links.task.yml' => '/_links.task.yml',
  ];

}
