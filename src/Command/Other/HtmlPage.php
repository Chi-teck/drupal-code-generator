<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\Generator;

/**
 * Implements other:html-page command.
 */
class HtmlPage extends Generator {

  protected $name = 'other:html-page';
  protected $description = 'Generates a simple html page';
  protected $alias = 'html-page';
  protected $label = 'HTML page';
  protected $destination = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->vars['file_name'] = $this->ask('File name', 'index.html');
    $this->addFile('{file_name}', 'other/html');
    $this->addFile('css/main.css')
      ->content("body{\n  background-color: #EEE;\n}\n");
    $this->addFile('js/main.js')
      ->content("console.log('It works!');\n");
  }

}
