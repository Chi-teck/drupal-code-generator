<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:theme-libraries command.
 */
class ThemeLibraries extends BaseGenerator {

  protected $name = 'd8:yml:theme-libraries';
  protected $description = 'Generates theme libraries yml file';
  protected $alias = 'theme-libraries';
  protected $label = 'Libraries (theme)';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('{machine_name}.libraries.yml')
      ->template('d8/yml/theme-libraries.twig');
  }

}
