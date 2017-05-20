<?php

namespace DrupalCodeGenerator\Helpers;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Output printer form generators.
 */
class OutputHandler extends Helper {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'dcg_output_handler';
  }

  /**
   * Prints summary.
   *
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $dumped_files
   *   List of created or updated files.
   * @param \Symfony\Component\Console\Command\Command $command
   *   The generator command.
   */
  public function printSummary(OutputInterface $output, array $dumped_files, Command $command) {
    // Multiple hooks can be dumped to the same file.
    $dumped_files = array_unique($dumped_files);
    if (count($dumped_files) > 0) {
      $output->writeln('<title>The following directories and files have been created or updated:</title>');
      foreach ($dumped_files as $file) {
        $output->writeln("- $file");
      }
    }
  }

}
