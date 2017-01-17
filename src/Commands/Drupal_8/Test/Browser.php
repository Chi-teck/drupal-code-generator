<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Test;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:test:browser command.
 */
class Browser extends BaseGenerator {

  protected $name = 'd8:test:browser';
  protected $description = 'Generates a browser based test';
  protected $alias = 'browser-test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'test_name' => ['Test name', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['test_name'] . 'Test');
    $path = 'tests/src/Functional/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/test/browser.twig', $vars);
  }

}
