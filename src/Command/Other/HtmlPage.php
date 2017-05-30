<?php

namespace DrupalCodeGenerator\Command\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implements other:html-page command.
 */
class HtmlPage extends BaseGenerator {

  protected $name = 'other:html-page';
  protected $description = 'Generates a simple html page';
  protected $alias = 'html-page';
  protected $destination = FALSE;

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
    $this->files['js/main.js'] = "console.log('It works!');";
  }

}
