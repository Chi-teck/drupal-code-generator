<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:module-info command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd8:yml:module-info';
  protected $description = 'Generates a module info yml file';
  protected $alias = 'module-info';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['description'] = new Question('Description', 'Module description.');
    $questions['package'] = new Question('Package', 'Custom');
    $questions['configure'] = new Question('Configuration page (route name)');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }

    $this->setFile($vars['machine_name'] . '.info.yml', 'd8/yml/module-info.twig', $vars);
  }

}
