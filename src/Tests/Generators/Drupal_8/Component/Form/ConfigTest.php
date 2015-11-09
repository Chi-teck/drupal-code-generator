<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:form:config command.
 */
class ConfigTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Form\Config';
    $this->answers = [
      'Example',
      'example',
      'SettingsForm',
    ];

    $this->target = 'SettingsForm.php';
    $this->fixture = __DIR__ . '/_config_' . $this->target;

    parent::setUp();
  }

}
