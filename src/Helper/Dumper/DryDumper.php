<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dumps asset to console output.
 */
final class DryDumper extends BaseDumper {

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'dry_dumper';
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpDirectory(Directory $directory, string $path): void {
    $this->io()->title($this->getPath($directory, $path) . ' (empty directory)');
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpFile(File $file, string $path): void {
    $this->io()->title($this->getPath($file, $path));
    $this->io()->writeln($file->getContent(), OutputInterface::OUTPUT_RAW);
  }

  /**
   * {@inheritdoc}
   */
  protected function dumpSymlink(Symlink $symlink, string $path): void {
    $this->io()->title($this->getPath($symlink, $path));
    $this->io()->writeln('Symlink to ' . $symlink->getTarget(), OutputInterface::OUTPUT_RAW);
  }

  /**
   * {@inheritdoc}
   */
  private function getPath(Asset $asset, string $path): string {
    return $this->io()->getInput()->getOption('full-path') ? $path : $asset->getPath();
  }

}
