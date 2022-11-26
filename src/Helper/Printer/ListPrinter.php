<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Printer;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;

/**
 * Prints assets as a bulleted list.
 */
final class ListPrinter extends Helper implements PrinterInterface, IOAwareInterface {

  use IOAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'assets_list_printer';
  }

  /**
   * {@inheritdoc}
   */
  public function printAssets(AssetCollection $assets, string $base_path = ''): void {
    if (\count($assets) === 0) {
      return;
    }

    $this->io()->title('The following directories and files have been created or updated:');

    $assets = $assets->getSorted();

    $print_asset = static fn (Asset $asset): string => self::formatPath($asset, $base_path);

    // Group results by asset type.
    $directories = \array_map($print_asset, \iterator_to_array($assets->getDirectories()));
    $files = \array_map($print_asset, \iterator_to_array($assets->getFiles()));
    $symlinks = \array_map($print_asset, \iterator_to_array($assets->getSymlinks()));

    $all_items = \array_merge($directories, $files, $symlinks);

    $this->io()->listing($all_items);
  }

  /**
   * Returns formatted path of a given asset.
   */
  private static function formatPath(Asset $asset, string $base_path): string {
    $path = $asset->getPath();
    if (!\str_starts_with($path, '/')) {
      $path = $base_path . $path;
    }
    return $path;
  }

}
