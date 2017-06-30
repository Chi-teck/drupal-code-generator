<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
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
    $questions = Utils::defaultPluginQuestions();

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label'] . 'Resource');

    $path = 'src/Plugin/rest/resource/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/plugin/rest-resource.twig', $vars);
  }

}
