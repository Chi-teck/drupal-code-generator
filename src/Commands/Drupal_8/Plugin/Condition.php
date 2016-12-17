<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
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
    $questions = Utils::defaultQuestions() + [
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin id'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['plugin_label']);

    $path = 'src/Plugin/Condition/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/condition.twig', $vars);
  }

}
