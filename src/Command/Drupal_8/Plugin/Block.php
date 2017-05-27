<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:block command.
 */
class Block extends BaseGenerator {

  protected $name = 'd8:plugin:block';
  protected $description = 'Generates block plugin';
  protected $alias = 'block';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'plugin_label' => ['Block admin label', 'Example'],
      'plugin_id' => ['Plugin ID'],
      'category' => ['Block category', 'Custom'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label'] . 'Block');

    $path = 'src/Plugin/Block/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/block.twig', $vars);
  }

}
