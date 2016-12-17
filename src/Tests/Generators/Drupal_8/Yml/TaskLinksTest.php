<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:task-links command.
 */
class TaskLinksTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\TaskLinks';

  protected $answers = ['example'];

  protected $fixtures = [
    'example.links.task.yml' => __DIR__ . '/_links.task.yml',
  ];

}
