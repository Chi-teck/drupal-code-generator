<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin\Access;

class CtoolsPluginAccessTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Access();
    $this->commandName = 'generate:d7:component:ctools-plugin:access';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      'User',
    ];
    $this->target = 'example.inc';
    $this->fixture = __DIR__ . '/access/_' . $this->target;

    parent::setUp();
  }

}
