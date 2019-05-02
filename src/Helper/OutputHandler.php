<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\OutputStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output printer for generators.
 */
class OutputHandler extends Helper {

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'output_handler';
  }

  /**
   * Prints summary.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Console input.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Console output.
   * @param \DrupalCodeGenerator\Asset[] $assets
   *   List of created or updated assets.
   * @param string $directory
   *   The working directory.
   */
  public function printSummary(InputInterface $input, OutputInterface $output, array $assets, string $directory) :void {

    if (count($assets) > 0) {

      $dumped_files = [];
      foreach ($assets as $asset) {
        $dumped_files[] = $asset->getPath();
      }

      // Multiple hooks can be dumped to the same file.
      $dumped_files = array_unique($dumped_files);

      usort($dumped_files, function ($a, $b) {
        $depth_a = substr_count($a, '/');
        $depth_b = substr_count($b, '/');
        // Top level files should be printed first.
        return $depth_a == $depth_b || ($depth_a > 1 && $depth_b > 1) ?
          strcmp($a, $b) : ($depth_a > $depth_b ? 1 : -1);
      });

      $io = new OutputStyle($input, $output);
      $io->title('The following directories and files have been created or updated:');
      $io->listing($dumped_files);
    }

  }

}
