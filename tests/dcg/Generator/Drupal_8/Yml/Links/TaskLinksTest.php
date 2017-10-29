<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:links:task command.
 */
class TaskTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\Links\Task';

  protected $interaction = [
    'Module machine name [%default_machine_name%]: ' => 'example',
  ];

  protected $fixtures = [
    'example.links.task.yml' => __DIR__ . '/_links.task.yml',
  ];

}
