<?php

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:html-page command.
 */
final class HtmlPage extends Generator {

  protected $name = 'misc:html-page';
  protected $description = 'Generates a simple html page';
  protected $alias = 'html-page';
  protected $label = 'HTML page';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $vars['file_name'] = $this->ask('File name', 'index.html');
    $this->addFile('{file_name}', 'index');
    $this->addFile('css/main.css')
      ->content("body{\n  background-color: #EEE;\n}\n");
    $this->addFile('js/main.js')
      ->content("console.log('It works!');\n");
  }

}
