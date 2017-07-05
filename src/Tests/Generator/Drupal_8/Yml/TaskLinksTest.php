<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:task-links command.
 */
class TaskLinksTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\TaskLinks';

  protected $interaction = [
    'Module machine name [%default_machine_name%]: ' => 'example',
  ];

  protected $fixtures = [
    'example.links.task.yml' => __DIR__ . '/_links.task.yml',
  ];

}
