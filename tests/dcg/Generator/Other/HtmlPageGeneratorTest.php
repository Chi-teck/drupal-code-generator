<?php

namespace DrupalCodeGenerator\Tests\Generator\Other;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for other:html-page command.
 */
class HtmlPageGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Other\HtmlPage';

  protected $answers = [
    'example.html',
  ];

  protected $interaction = [
    'File name [index.html]:' => 'example.html',
  ];

  protected $fixtures = [
    'example.html' => __DIR__ . '/_html_page.html',
    'css/main.css' => __DIR__ . '/_html_page.css',
    'js/main.js' => __DIR__ . '/_html_page.js',
  ];

}
