<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:template command.
 */
class TemplateTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Template';

  protected $answers = [
    'Example',
    'example',
    'example-foo',
    TRUE,
    TRUE,
  ];

  protected $fixtures = [
    'templates/example-foo.html.twig' => __DIR__ . '/_template.twig',
    'example.module' => __DIR__ . '/_template.module',
  ];

}
