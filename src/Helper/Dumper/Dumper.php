<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Asset dumper form generators.
 */
class Dumper extends Helper implements IOAwareInterface {

  use IOAwareTrait;

  public function __construct(private Filesystem $filesystem) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'dumper';
  }

  /**
   * Dumps the generated code to file system or stdout.
   */
  public function dump(AssetCollection $assets, string $destination): AssetCollection {

    $dumped_assets = new AssetCollection();

    $asset_dumper = $this->io->getInput()->getOption('dry-run') ?
      new DryAssetDumper($this->io) :
      new FileSystemAssetDumper($this->filesystem);

    foreach ($assets as $asset) {
      $path = $destination . '/' . $asset->getPath();

      $resolved_asset = clone $asset;
      if ($this->filesystem->exists($path)) {
        $resolved_asset = $asset->getResolver($this->io)->resolve($asset, $path);
      }
      elseif ($asset->isVirtual()) {
        continue;
      }

      if ($resolved_asset) {
        $dumped_assets[] = $asset_dumper->dump($resolved_asset, $path);
      }
    }

    return $dumped_assets;
  }

}
