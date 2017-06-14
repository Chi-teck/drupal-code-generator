<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:content-type command.
 */
class ContentTypeTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\CToolsPlugin\ContentType';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'example',
    'Some description.',
    'Custom',
    'Node',
  ];

  protected $fixtures = [
    'plugins/content_types/example.inc' => __DIR__ . '/_content_type.inc',
  ];

}
