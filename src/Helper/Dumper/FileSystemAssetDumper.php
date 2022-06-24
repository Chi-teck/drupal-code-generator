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

  public function __construct(
    private Filesystem $filesystem,
  ) {}

  /**
   * Dumps an asset to the file system.
   */
  public function dump(Asset $asset, string $path): ?Asset {
    return match ($asset::class) {
      Directory::class => $this->dumpDirectory($asset, $path),
      File::class => $this->dumpFile($asset, $path),
      Symlink::class => $this->dumpSymlink($asset, $path),
    };
  }

  private function dumpDirectory(Directory $directory, string $path): Directory {
    $this->filesystem->mkdir($path, $directory->getMode());
    return clone $directory;
  }

  private function dumpFile(File $file, string $path): ?File {
    // Nothing to dump.
    if ($file->getContent() === NULL) {
      return NULL;
    }
    $this->filesystem->dumpFile($path, $file->getContent());
    $this->filesystem->chmod($path, $file->getMode());
    return clone $file;
  }

  private function dumpSymlink(Symlink $symlink, string $path): Symlink {
    $file_exists = $this->filesystem->exists($path);
    if ($file_exists) {
      $this->filesystem->remove($path);
    }
    if (!@\symlink($symlink->getTarget(), $path)) {
      throw new \RuntimeException('Could not create a symlink to ' . $symlink->getTarget());
    }
    $this->filesystem->chmod($path, $symlink->getMode());
    return clone $symlink;
  }

}
