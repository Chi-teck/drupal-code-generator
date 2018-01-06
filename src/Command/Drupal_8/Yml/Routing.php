<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:routing command.
 */
class Routing extends BaseGenerator {

  protected $name = 'd8:yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['machine_name']) . 'Controller';

    $this->addFile()
      ->path('{machine_name}.routing.yml')
      ->template('d8/yml/routing.twig');
  }

}
