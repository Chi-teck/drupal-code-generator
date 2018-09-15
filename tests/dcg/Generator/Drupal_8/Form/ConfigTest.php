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
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.settings]:' => 'foo.example',
    'Route path [/admin/settings]:' => '/foo/example',
    'Route title [Settings]:' => 'Yo',
    'Route permission [administer site configuration]:' => 'administer site configuration',
  ];

  protected $fixtures = [
    'foo.routing.yml' => __DIR__ . '/_config_routing.yml',
    'src/Form/SettingsForm.php' => __DIR__ . '/_config.php',
  ];

}
