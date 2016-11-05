<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for other:html-page command.
 */
class HtmlPageTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Other\HtmlPage';
    $this->answers = [
      'example.html',
    ];
    $this->target = 'example.html';
    $this->fixture = __DIR__ . '/_html_page.html';
    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {
    $this->execute();

    $output = "The following directories and files have been created or updated:\n- $this->target\n";
    $output .= "- css/main.css\n- js/main.js\n";

    $this->assertEquals($output, $this->commandTester->getDisplay());

    $this->checkFile($this->target, $this->fixture);
  }

}
