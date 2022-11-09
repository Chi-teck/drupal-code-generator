<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\InputOutput;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption as Option;

final class DefaultOptions {

  public static function apply(Command $command): void {
    $command
      ->addOption('working-dir', 'd', Option::VALUE_OPTIONAL, 'Working directory')
      ->addOption('answer', 'a', Option::VALUE_IS_ARRAY | Option::VALUE_OPTIONAL, 'Answer to generator question')
      ->addOption('dry-run', NULL, Option::VALUE_NONE, 'Output the generated code but not save it to file system')
      ->addOption('full-path', NULL, Option::VALUE_NONE, 'Print full path to generated assets')
      ->addOption('destination', NULL, Option::VALUE_OPTIONAL, 'Path to a base directory for file writing')
      ->addOption('replace', NULL, Option::VALUE_NONE, 'Replace existing assets without confirmation');
  }

}
