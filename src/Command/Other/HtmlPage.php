<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['file_name'] = new Question('File name', 'index.html');

    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['file_name'], 'other/html.twig', $vars);

    $this->files['css/main.css'] = 'body{background-color: #EEE}';
    $this->files['js/main.js'] = "console.log('It works!');";
  }

}
