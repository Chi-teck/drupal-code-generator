<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use function substr_count;

/**
 * Output printer for generators.
 */
class ResultPrinter extends Helper implements IOAwareInterface {

  use IOAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'result_printer';
  }

  /**
   * Prints summary.
   *
   * @param \DrupalCodeGenerator\Asset\AssetCollection $assets
   *   List of created or updated assets.
   * @param string $base_path
   *   (Optional) Base path.
   */
  public function printResult(AssetCollection $assets, string $base_path = ''): void {

    if (count($assets) == 0) {
      return;
    }

    $this->io->title('The following directories and files have been created or updated:');

    // Table.
    if ($this->io->isVerbose()) {
      $headers[] = ['Type', 'Path', 'Lines', 'Size'];

      $rows = [];

      foreach ($assets->getDirectories()->getSorted() as $asset) {
        $rows[] = ['directory', $base_path . $asset->getPath(), '-', '-'];
      }

      $total_size = 0;
      $total_lines = 0;

      foreach ($assets->getFiles()->getSorted() as $asset) {
        $size = mb_strlen($asset->getContent());
        $total_size += $size;
        $lines = $size == 0 ? 0 : substr_count($asset->getContent(), "\n") + 1;
        $total_lines += $lines;
        $rows[] = ['file', $base_path . $asset->getPath(), $lines, $size];
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
      $this->io
        ->buildTable($headers, $rows)
        ->setColumnStyle(2, $right_aligned)
        ->setColumnStyle(3, $right_aligned)
        ->render();

      $this->io->newLine();
    }
    // Bulleted list.
    else {
      $dumped_files = [];
      foreach ($assets->getDirectories()->getSorted() as $asset) {
        $dumped_files[] = $base_path . $asset->getPath();
      }
      foreach ($assets->getFiles()->getSorted() as $asset) {
        $dumped_files[] = $base_path . $asset->getPath();
      }
      $this->io->listing($dumped_files);
    }

  }

}
