<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:template command.
 */
class TemplateTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Template';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Template name [example]:' => 'foo',
    'Create theme hook? [Yes]:' => 'Yes',
    'Create preprocess hook? [Yes]:' => 'Yes',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_template.module',
    'templates/foo.html.twig' => __DIR__ . '/_template.twig',
  ];

}
