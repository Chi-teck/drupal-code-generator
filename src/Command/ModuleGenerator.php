<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for module generators.
 */
abstract class ModuleGenerator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault() :array {

    $directory = $this->directory;

    $root_directory = basename(Utils::getExtensionRoot($directory) ?: $directory);
    $default_value = Utils::machine2human($root_directory);

    $questions['name'] = new Question('Module name', $default_value);
    $questions['name']->setValidator([Utils::class, 'validateRequired']);

    $default_value = function (array $vars) use ($directory) :string {
      return Utils::human2machine($vars['name'] ?? basename($directory));
    };
    $questions['machine_name'] = new Question('Module machine name', $default_value);
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    return $this->collectVars($questions);
  }

}
