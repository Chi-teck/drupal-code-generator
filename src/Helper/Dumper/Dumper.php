<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Helper\Resolver\ChainedResolver;
use DrupalCodeGenerator\Helper\Resolver\DirectoryResolver;
use DrupalCodeGenerator\Helper\Resolver\FileResolver;
use DrupalCodeGenerator\Helper\Resolver\SymlinkResolver;
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

    $directory_resolver = new DirectoryResolver();
    $file_resolver = new FileResolver($options, $this->io);
    $symlink_resolver = new SymlinkResolver($options, $this->io);

    $default_resolver = new ChainedResolver($directory_resolver, $file_resolver, $symlink_resolver);
    $asset_dumper = $options->dryRun ?
      new DryAssetDumper($this->io, $options) :
      new FileSystemAssetDumper($this->filesystem);

    foreach ($assets as $asset) {
      $path = $destination . '/' . $asset->getPath();

      if ($this->filesystem->exists($path)) {
        $resolver = $asset->getResolver() ?? $default_resolver;
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
