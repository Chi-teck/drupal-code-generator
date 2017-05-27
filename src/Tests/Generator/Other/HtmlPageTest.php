<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for other:html-page command.
 */
class HtmlPageTest extends GeneratorTestCase {

  protected $class = 'Other\HtmlPage';

  protected $answers = [
    'example.html',
  ];

  protected $fixtures = [
    'example.html' => __DIR__ . '/_html_page.html',
    'css/main.css' => NULL,
    'js/main.js' => NULL,
  ];

}
