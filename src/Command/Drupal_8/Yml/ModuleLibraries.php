<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:module-libraries command.
 */
class ModuleLibraries extends ModuleGenerator {

  protected $name = 'd8:yml:module-libraries';
  protected $description = 'Generates module libraries yml file';
  protected $alias = 'module-libraries';
  protected $label = 'Libraries (module)';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('{machine_name}.libraries.yml')
      ->template('d8/yml/module-libraries.twig');
  }

}
