<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;

/**
 * Dumps assets to file system.
 */
final class FileSystemDumper extends BaseDumper {

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'filesystem_dumper';
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpDirectory(Directory $directory, string $path): void {
    $this->filesystem->mkdir($path, $directory->getMode());
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpFile(File $file, string $path): void {
    $this->filesystem->dumpFile($path, $file->getContent());
    $this->filesystem->chmod($path, $file->getMode());
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpSymlink(Symlink $symlink, string $path): void {
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
