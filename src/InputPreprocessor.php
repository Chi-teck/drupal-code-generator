<?php

namespace DrupalCodeGenerator;
use DrupalCodeGenerator\Commands\GeneratorInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 *
 */
class InputPreprocessor extends Helper {

  public function preprocess(array &$questions, GeneratorInterface $command) {

    $questions['name'][3] = ['Node', 'Views', 'Rules'];
  }

  public function getName() {
    return 'input_preprocessor';
  }

}
