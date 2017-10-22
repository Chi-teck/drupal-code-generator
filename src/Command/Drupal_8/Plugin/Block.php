<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::defaultPluginQuestions();
    $questions['plugin_label'] = new Question('Block admin label', 'Example');
    $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);
    $questions['category'] = new Question('Block category', 'Custom');

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label'] . 'Block');

    $path = 'src/Plugin/Block/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/plugin/block.twig', $vars);
    $this->files['config/schema/' . $vars['machine_name'] . '.schema.yml'] = [
      'content' => $this->render('d8/plugin/block-schema.twig', $vars),
      'action' => 'append',
    ];
  }

}
