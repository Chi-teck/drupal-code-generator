<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:module command.
 */
class Module extends BaseGenerator {

  protected $name = 'd7:module';
  protected $description = 'Generates Drupal 7 module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['description'] = new Question('Module description', 'Module description.');
    $questions['package'] = new Question('Package', 'Custom');

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];

    $this->setFile($prefix . '.info', 'd7/module-info.twig', $vars);
    $this->setFile($prefix . '.module', 'd7/module.twig', $vars);
    $this->setFile($prefix . '.install', 'd7/install.twig', $vars);
    $this->setFile($prefix . '.admin.inc', 'd7/admin.inc.twig', $vars);
    $this->setFile($prefix . '.pages.inc', 'd7/pages.inc.twig', $vars);

    $js_path = $vars['machine_name'] . '/' . str_replace('_', '-', $vars['machine_name']) . '.js';
    $this->setFile($js_path, 'd7/javascript.twig', $vars);
  }

}
