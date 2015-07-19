<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Commands\Other\HtmlPage;

class HtmlPageTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new HtmlPage();
    $this->commandName = 'generate:other:html-page';
    $this->answers = [
      'example.html',
    ];
    $this->target = 'example.html';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
