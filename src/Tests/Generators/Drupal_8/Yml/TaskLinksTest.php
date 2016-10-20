<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:task-links command.
 */
class TaskLinksTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\TaskLinks';
    $this->answers = ['example'];
    $this->target = 'example.links.task.yml';
    $this->fixture = __DIR__ . '/_links.task.yml';

    parent::setUp();
  }

}
