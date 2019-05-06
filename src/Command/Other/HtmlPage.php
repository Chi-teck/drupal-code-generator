<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Question\Question;

/**
 * Implements other:html-page command.
 */
class HtmlPage extends BaseGenerator {

  protected $name = 'other:html-page';
  protected $description = 'Generates a simple html page';
  protected $alias = 'html-page';
  protected $label = 'HTML page';
  protected $destination = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions['file_name'] = new Question('File name', 'index.html');

    $this->collectVars($questions);

    $this->addFile()
      ->path('{file_name}')
      ->template('other/html.twig');

    $this->addFile()
      ->path('css/main.css')
      ->content("body{\n  background-color: #EEE;\n}\n");

    $this->addFile()
      ->path('js/main.js')
      ->content("console.log('It works!');\n");
  }

}
