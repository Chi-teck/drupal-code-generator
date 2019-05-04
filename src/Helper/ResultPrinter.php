<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\OutputStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output printer for generators.
 */
class ResultPrinter extends Helper {

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'result_printer';
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
  public function printResult(InputInterface $input, OutputInterface $output, array $assets, string $directory) :void {

    if (count($assets) > 0) {

      $assets = array_unique($assets);

      usort($assets, function (Asset $a, Asset $b) :int {
        $depth_a = substr_count($a, '/');
        $depth_b = substr_count($b, '/');
        // Top level files should be printed first.
        return $depth_a == $depth_b || ($depth_a > 1 && $depth_b > 1) ?
          strcmp($a, $b) : ($depth_a > $depth_b ? 1 : -1);
      });

      $io = new OutputStyle($input, $output);
      $io->title('The following directories and files have been created or updated:');

      // Table.
      if ($output->isVerbose()) {
        $headers[] = ['Type', 'Path', 'Lines', 'Size'];

        $rows = [];
        $total_size = 0;
        $total_lines = 0;
        foreach ($assets as $asset) {
          $size = mb_strlen($asset->getContent());
          $total_size += $size;
          $lines = $asset->getContent() === NULL ? 0 : substr_count($asset->getContent(), "\n") + 1;
          $total_lines += $lines;
          $rows[] = [
            $asset->getType(),
            $asset->getPath(),
            $lines,
            $size,
          ];
        }
        $rows[] = new TableSeparator();

        // Summary.
        $total_assets = count($assets);
        $rows[] = [
          NULL,
          sprintf('Total: %d %s', $total_assets, $total_assets == 1 ? 'asset' : 'assets'),
          $total_lines,
          self::formatMemory($total_size),
        ];

        $right_aligned = (new TableStyle())->setPadType(STR_PAD_LEFT);
        $io->buildTable($headers, $rows)
          ->setColumnStyle(2, $right_aligned)
          ->setColumnStyle(3, $right_aligned)
          ->render();

        $io->newLine();
      }
      // Bulleted list.
      else {
        $io->listing($assets);
      }

    }

  }

}
