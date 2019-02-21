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
  protected $label = 'REST resource';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions();
    $questions += Utils::pluginQuestions('Resource');

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/rest/resource/{class}.php')
      ->template('d8/plugin/rest-resource.twig');
  }

}
