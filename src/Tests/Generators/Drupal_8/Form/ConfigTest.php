<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:form:config command.
 */
class ConfigTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Form\Config';
    $this->answers = [
      'Foo',
      'foo',
      'SettingsForm',
      'foo_settings'
    ];

    $this->target = 'SettingsForm.php';
    $this->fixture = __DIR__ . '/_config.php';

    parent::setUp();
  }

}
