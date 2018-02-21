<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:render-element command.
 */
class RenderElement extends BaseGenerator {

  protected $name = 'd8:render-element';
  protected $description = 'Generates Drupal 8 render element';
  protected $alias = 'render-element';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $this->collectVars($input, $output, Utils::defaultQuestions());
    $this->addFile()
      ->path('src/Element/Entity.php')
      ->template('d8/render-element.twig');
  }

}
