<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for Misc:html-page command.
 */
final class HtmlPageTest extends BaseGeneratorTest {

  protected string $class = 'Misc\HtmlPage';

  protected $answers = [
    'example.html',
  ];

  protected array $interaction = [
    'File name [index.html]:' => 'example.html',
  ];

  protected array $fixtures = [
    'example.html' => '/_html_page.html',
    'css/main.css' => '/_html_page.css',
    'js/main.js' => '/_html_page.js',
  ];

}
