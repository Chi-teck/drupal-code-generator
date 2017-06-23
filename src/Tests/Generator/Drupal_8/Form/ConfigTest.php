<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:config command.
 */
class ConfigTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Config';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Class [SettingsForm]: ' => 'SettingsForm',
    'Form ID [foo_settings]: ' => 'foo_settings',
  ];

  protected $fixtures = [
    'src/Form/SettingsForm.php' => __DIR__ . '/_config.php',
  ];

}
