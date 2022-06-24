<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Dumps a single asset.
 */
final class DryAssetDumper {

  public function __construct(
    private GeneratorStyleInterface $io,
    private DumperOptions $options,
  ) {}

  /**
   * Simulates asset dumping.
   */
  public function dump(Asset $asset, string $path): Asset {
    match (TRUE) {
      $asset instanceof Directory => $this->dumpDirectory($asset, $path),
      $asset instanceof File => $this->dumpFile($asset, $path),
      $asset instanceof Symlink => $this->dumpSymlink($asset, $path),
    };
    return clone $asset;
  }

  private function dumpDirectory(Directory $directory, string $path): void {
    $this->io->title(($this->options->fullPath ? $path : $directory->getPath()) . ' (empty directory)');
  }

  private function dumpFile(File $file, string $path): void {
    $this->io->title($this->options->fullPath ? $path : $file->getPath());
    $this->io->writeln($file->getContent(), OutputInterface::OUTPUT_RAW);
  }

  private function dumpSymlink(Symlink $symlink, string $path): void {
    $this->io->title($this->options->fullPath ? $path : $symlink->getPath());
    $this->io->writeln('Symlink to ' . $symlink->getTarget(), OutputInterface::OUTPUT_RAW);
  }

}
