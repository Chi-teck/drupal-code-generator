<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:form:config command.
 */
class ConfigTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Form\Config';

  protected $answers = [
    'Foo',
    'foo',
    'SettingsForm',
    'foo_settings',
  ];

  protected $fixtures = [
    'src/Form/SettingsForm.php' => __DIR__ . '/_config.php',
  ];

}
