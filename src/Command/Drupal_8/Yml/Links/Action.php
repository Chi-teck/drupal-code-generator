<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:links:action command.
 */
class Action extends ModuleGenerator {

  protected $name = 'd8:yml:links:action';
  protected $description = 'Generates a links.action yml file';
  protected $alias = 'action-links';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('{machine_name}.links.action.yml')
      ->template('d8/yml/links.action.twig');
  }

}
