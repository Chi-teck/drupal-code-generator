<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd8:test:javascript';
  protected $description = 'Generates a javascript based test';
  protected $alias = 'javascript-test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $vars = $this->collectVars($input, $output, $questions);

    $path = 'tests/src/FunctionalJavascript/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/test/javascript.twig', $vars);
  }

}
