<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for theme generators.
 */
abstract class ThemeGenerator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault() :array {

    $root_directory = basename(Utils::getExtensionRoot($this->directory) ?: $this->directory);

    $default_value = Utils::machine2human($root_directory);
    $name_question = new Question('Theme name', $default_value);
    $name_question->setValidator([Utils::class, 'validateRequired']);

    $this->vars['name'] = $this->askQuestion($name_question);

    $default_value = Utils::human2machine($this->vars['name'] ?? basename($this->directory));
    $machine_name_question = new Question('Theme machine name', $default_value);
    $machine_name_question->setValidator([Utils::class, 'validateMachineName']);
    $this->vars['machine_name'] = $this->askQuestion($machine_name_question);

    return $this->vars;
  }

}
