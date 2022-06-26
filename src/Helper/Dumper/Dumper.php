<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Helper\DumperOptions;
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
  public function dump(AssetCollection $assets, string $destination, DumperOptions $options): AssetCollection {

    $dumped_assets = new AssetCollection();

    $asset_dumper = $options->dryRun ?
      new DryAssetDumper($this->io, $options) :
      new FileSystemAssetDumper($this->filesystem);

    foreach ($assets as $asset) {
      $path = $destination . '/' . $asset->getPath();

      if ($this->filesystem->exists($path)) {
        $resolver = $asset->getResolver($this->io, $options);
        if (!$resolver->supports($asset)) {
          throw new \LogicException(\sprintf('Asset "%s" already exists and cannot be resolved.', \get_debug_type($asset)));
        }
        $asset = $resolver->resolve($asset, $path);
        if ($asset === NULL) {
          continue;
        }
      }

      if ($asset = $asset_dumper->dump($asset, $path)) {
        $dumped_assets[] = $asset;
      }
    }

    return $dumped_assets;
  }

}
