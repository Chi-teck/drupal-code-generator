<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $this->collectVars($input, $output, $questions);
    $this->addFile()
      ->path('src/Element/Entity.php')
      ->template('d8/render-element.twig');
  }

}
