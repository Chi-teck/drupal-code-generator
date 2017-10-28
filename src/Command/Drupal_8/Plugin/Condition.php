<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:condition command.
 */
class Condition extends BaseGenerator {

  protected $name = 'd8:plugin:condition';
  protected $description = 'Generates condition plugin';
  protected $alias = 'condition';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $this->setFile(
      'src/Plugin/Condition/' . $vars['class'] . '.php',
      'd8/plugin/condition.twig',
      $vars
    );

    $this->files['config/schema/' . $vars['machine_name'] . '.schema.yml'] = [
      'content' => $this->render('d8/plugin/condition-schema.twig', $vars),
      'action' => 'append',
    ];
  }

}
