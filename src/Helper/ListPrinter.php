<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;

/**
 * Prints assets as a bulleted list.
 */
final class ListPrinter extends Helper implements IOAwareInterface {

  use IOAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'assets_list_printer';
  }

  /**
   * Prints summary.
   */
  public function printAssets(AssetCollection $assets, string $base_path = ''): void {
    if (\count($assets) === 0) {
      return;
    }
    $this->io->title('The following directories and files have been created or updated:');
    $dumped_files = [];
    // Group results by asset type.
    $assets = $assets->getSorted();
    foreach ($assets->getDirectories() as $directory) {
      $dumped_files[] = $this->formatPath($base_path, $directory);
    }
    foreach ($assets->getFiles() as $file) {
      $dumped_files[] = $this->formatPath($base_path, $file);
    }
    foreach ($assets->getSymlinks() as $symlink) {
      $dumped_files[] = $this->formatPath($base_path, $symlink);
    }
    $this->io()->listing($dumped_files);
  }

  /**
   * Returns formatted path of a given asset.
   */
  private function formatPath(string $base_path, Asset $asset): string {
    $path = $asset->getPath();
    if ($path[0] != '/') {
      $path = $base_path . $path;
    }
    return $path;
  }

}
