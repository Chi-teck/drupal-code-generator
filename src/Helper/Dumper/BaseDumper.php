<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Asset dumper form generators.
 */
abstract class BaseDumper extends Helper implements DumperInterface, IOAwareInterface {

  use IOAwareTrait;

  /**
   * Constructs the object.
   */
  public function __construct(protected readonly Filesystem $filesystem) {}

  /**
   * {@inheritdoc}
   */
  final public function dump(AssetCollection $assets, string $destination): AssetCollection {

    $dumped_assets = new AssetCollection();

    foreach ($assets as $asset) {
      $path = $destination . '/' . $asset->getPath();

      $resolved_asset = clone $asset;
      if ($this->filesystem->exists($path)) {
        $resolved_asset = $asset->getResolver($this->io())->resolve($asset, $path);
      }
      elseif ($asset->isVirtual()) {
        continue;
      }

      if ($resolved_asset) {
        match (TRUE) {
          $resolved_asset instanceof Directory => $this->dumpDirectory($resolved_asset, $path),
          $resolved_asset instanceof File => $this->dumpFile($resolved_asset, $path),
          $resolved_asset instanceof Symlink => $this->dumpSymlink($resolved_asset, $path),
          default => throw new \LogicException('Unsupported asset type'),
        };
        $dumped_assets[] = $resolved_asset;
      }
    }

    return $dumped_assets;
  }

  /**
   * Creates a directory.
   */
  abstract protected function dumpDirectory(Directory $directory, string $path): void;

  /**
   * Dumps a file.
   */
  abstract protected function dumpFile(File $file, string $path): void;

  /**
   * Dumps a symlink.
   */
  abstract protected function dumpSymlink(Symlink $symlink, string $path): void;

}
