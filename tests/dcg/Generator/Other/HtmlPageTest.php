<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:html-page command.
 */
class HtmlPageTest extends GeneratorBaseTest {

  protected $class = 'Other\HtmlPage';

  protected $answers = [
    'example.html',
  ];

  protected $interaction = [
    'File name [index.html]:' => 'example.html',
  ];

  protected $fixtures = [
    'example.html' => __DIR__ . '/_html_page.html',
    'css/main.css' => NULL,
    'js/main.js' => NULL,
  ];

}
