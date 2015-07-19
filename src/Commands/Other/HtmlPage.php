<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements generate:other:html-page command.
 */
class HtmlPage extends BaseGenerator {

  protected static $name = 'generate:other:html-page';
  protected static $description = 'Generate a simple html page.';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'file_name' => ['File name', 'index.html'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['file_name']] = $this->render('other/html.twig', $vars);
    $this->files['css/main.css'] = 'body{background-color: #EEE}';
    $this->files['js/main.js'] = 'console.log("It works!")';
  }

}
