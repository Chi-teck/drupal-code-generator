<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:config command.
 */
class ConfigTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Config';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [SettingsForm]:' => 'SettingsForm',
    'Form ID [foo_settings]:' => 'foo_settings',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.example]:' => 'foo.example',
    'Route path [/foo/example]:' => '/foo/example',
    'Route title [Example]:' => 'Yo',
    'Route permission [administer site configuration]:' => 'administer site configuration',
  ];

  protected $fixtures = [
    'foo.routing.yml' => __DIR__ . '/_config_routing.yml',
    'src/Form/SettingsForm.php' => __DIR__ . '/_config.php',
  ];

}
