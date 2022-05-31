<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml\Links;

use DrupalCodeGenerator\Command\Yml\Links\Task;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:links:task generator.
 */
class TaskTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_task';

  public function testGenerator(): void {

    $this->execute(Task::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to task-links generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.links.task.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.links.task.yml');
  }

}
