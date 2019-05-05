<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\InputAwareInterface;
use DrupalCodeGenerator\InputAwareTrait;
use DrupalCodeGenerator\OutputAwareInterface;
use DrupalCodeGenerator\OutputAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;

/**
 * Output printer for generators.
 */
class ResultPrinter extends Helper implements InputAwareInterface, OutputAwareInterface {

  use InputAwareTrait;
  use OutputAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'result_printer';
  }

  /**
   * Prints summary.
   *
   * @param \DrupalCodeGenerator\Asset[] $assets
   *   List of created or updated assets.
   * @param string $base_path
   *   (Optional) Base path.
   */
  public function printResult(array $assets, string $base_path = '') :void {

    if (count($assets) == 0) {
      return;
    }

    $assets = array_unique($assets);

    usort($assets, function (Asset $a, Asset $b) :int {
      $depth_a = substr_count($a, '/');
      $depth_b = substr_count($b, '/');
      // Top level files should be printed first.
      return $depth_a == $depth_b || ($depth_a > 1 && $depth_b > 1) ?
        strcmp($a, $b) : ($depth_a > $depth_b ? 1 : -1);
    });

    /** @var \DrupalCodeGenerator\Helper\OutputStyleFactory $output_style_factory */
    $output_style_factory = $this->getHelperSet()->get('output_style_factory');
    $io = $output_style_factory->getOutputStyle();
    $io->title('The following directories and files have been created or updated:');

    // Table.
    if ($io->isVerbose()) {
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
          $base_path . $asset->getPath(),
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
      $dumped_files = [];
      foreach ($assets as $asset) {
        $dumped_files[] = $base_path . $asset->getPath();
      }
      $io->listing($dumped_files);
    }

  }

}
