<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:rest-resource command.
 */
class RestResource extends BaseGenerator {

  protected $name = 'd8:plugin:rest-resource';
  protected $description = 'Generates rest resource plugin';
  protected $alias = 'rest-resource';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin ID'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['plugin_label'] . 'Resource');

    $path = 'src/Plugin/rest/resource/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/rest-resource.twig', $vars);
  }

}
