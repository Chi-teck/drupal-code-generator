<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Dumps a single asset.
 */
final class FileSystemAssetDumper {

  public function __construct(readonly private Filesystem $filesystem) {}

  /**
   * Dumps an asset to the file system.
   */
  public function dump(Asset $asset, string $path): void {
    match (TRUE) {
      $asset instanceof Directory => $this->dumpDirectory($asset, $path),
      $asset instanceof File => $this->dumpFile($asset, $path),
      $asset instanceof Symlink => $this->dumpSymlink($asset, $path),
      default => throw new \LogicException('Unsupported asset type'),
    };
  }

  private function dumpDirectory(Directory $directory, string $path): void {
    $this->filesystem->mkdir($path, $directory->getMode());
  }

  private function dumpFile(File $file, string $path): void {
    $this->filesystem->dumpFile($path, $file->getContent());
    $this->filesystem->chmod($path, $file->getMode());
  }

  private function dumpSymlink(Symlink $symlink, string $path): void {
    $file_exists = $this->filesystem->exists($path);
    if ($file_exists) {
      $this->filesystem->remove($path);
    }
    if (!@\symlink($symlink->getTarget(), $path)) {
      throw new \RuntimeException('Could not create a symlink to ' . $symlink->getTarget());
    }
    $this->filesystem->chmod($path, $symlink->getMode());
  }

}
