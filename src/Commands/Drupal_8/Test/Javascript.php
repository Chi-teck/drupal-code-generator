<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Test;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = Utils::defaultQuestions() + [
      'test_name' => ['Test name', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['test_name'] . 'Test');
    $path = 'tests/src/FunctionalJavascript/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/test/javascript.twig', $vars);
  }

}
