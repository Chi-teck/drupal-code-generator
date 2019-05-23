<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:links:task command.
 */
class TaskLinksGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\Links\Task';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.task.yml' => __DIR__ . '/_links.task.yml',
  ];

}
