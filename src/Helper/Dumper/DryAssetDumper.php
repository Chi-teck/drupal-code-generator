<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\InputOutput\IO;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dumps a single asset.
 */
final class DryAssetDumper {

  public function __construct(readonly private IO $io) {}

  /**
   * Simulates asset dumping.
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
    $this->io->title($this->getPath($directory, $path) . ' (empty directory)');
  }

  private function dumpFile(File $file, string $path): void {
    $this->io->title($this->getPath($file, $path));
    $this->io->writeln($file->getContent(), OutputInterface::OUTPUT_RAW);
  }

  private function dumpSymlink(Symlink $symlink, string $path): void {
    $this->io->title($this->getPath($symlink, $path));
    $this->io->writeln('Symlink to ' . $symlink->getTarget(), OutputInterface::OUTPUT_RAW);
  }

  private function getPath(Asset $asset, string $path): string {
    return $this->io->getInput()->getOption('full-path') ? $path : $asset->getPath();
  }

}
