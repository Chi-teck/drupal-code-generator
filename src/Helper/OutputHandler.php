<?php

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output printer for generators.
 */
class OutputHandler extends Helper {

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'dcg_output_handler';
  }

  /**
   * Prints summary.
   *
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param \DrupalCodeGenerator\Asset[] $assets
   *   List of created or updated assets.
   * @param string $directory
   *   The working directory.
   */
  public function printSummary(OutputInterface $output, array $assets, string $directory) :void {

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

      $output->writeln('');
      $output->writeln(' The following directories and files have been created or updated:');
      $output->writeln('<fg=cyan;options=bold>–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––</>');
      foreach ($dumped_files as $file) {
        $output->writeln(" • $file");
      }
      $output->writeln('');
    }

  }

}
