<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Printer;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;

/**
 * Prints assets in tabular form.
 */
final class TablePrinter extends Helper implements PrinterInterface, IOAwareInterface {

  use IOAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'assets_table_printer';
  }

  /**
   * {@inheritdoc}
   */
  public function printAssets(AssetCollection $assets, string $base_path = ''): void {
    if (\count($assets) === 0) {
      return;
    }

    $this->io()->title('The following directories and files have been created or updated:');

    /** @psalm-var non-empty-list<non-empty-list<string>> $headers */
    $headers[] = ['Type', 'Path', 'Lines', 'Size'];

    $rows = [];
    foreach ($assets->getDirectories()->getSorted() as $directory) {
      $rows[] = ['directory', $this->formatPath($base_path, $directory), '-', '-'];
    }

    $total_size = $total_lines = 0;
    foreach ($assets->getFiles()->getSorted() as $file) {
      /** @var \DrupalCodeGenerator\Asset\File $file */
      $size = \mb_strlen($file->getContent());
      $total_size += $size;
      $lines = $size === 0 ? 0 : \substr_count($file->getContent(), "\n") + 1;
      $total_lines += $lines;
      $rows[] = ['file', $this->formatPath($base_path, $file), $lines, $size];
    }

    foreach ($assets->getSymlinks()->getSorted() as $symlink) {
      $rows[] = ['symlink', $this->formatPath($base_path, $symlink), '-', '-'];
    }

    $rows[] = new TableSeparator();

    // Summary.
    $total_assets = \count($assets);
    $rows[] = [
      '',
      \sprintf('Total: %d %s', $total_assets, $total_assets === 1 ? 'asset' : 'assets'),
      $total_lines,
      self::formatMemory($total_size),
    ];

    $right_aligned = (new TableStyle())->setPadType(\STR_PAD_LEFT);
    $this->io()
      ->buildTable($headers, $rows)
      ->setColumnStyle(2, $right_aligned)
      ->setColumnStyle(3, $right_aligned)
      ->render();

    $this->io()->newLine();
  }

  /**
   * Returns formatted path of a given asset.
   */
  protected function formatPath(string $base_path, Asset $asset): string {
    $path = $asset->getPath();
    if (!\str_starts_with($path, '/')) {
      $path = $base_path . $path;
    }
    return $path;
  }

}
