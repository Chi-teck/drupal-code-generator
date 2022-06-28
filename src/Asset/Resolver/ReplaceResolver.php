<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class ReplaceResolver implements ResolverInterface {

  public function __construct(private GeneratorStyleInterface $io) {}

  public function resolve(Asset $asset, string $path): File|Symlink {
    if (!$asset instanceof File && !$asset instanceof Symlink) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $resolved_asset = clone $asset;
    if (!$this->shouldReplace($path)) {
      $resolved_asset->setVirtual(TRUE);
    }
    return $resolved_asset;
  }

  /**
   * Checks if the asset can be replaced.
   */
  private function shouldReplace(string $path): bool {
    return $this->io->getInput()->getOption('replace') ||
           $this->io->getInput()->getOption('dry-run') ||
           $this->io->confirm("The file <comment>$path</comment> already exists. Would you like to replace it?");
  }

}
