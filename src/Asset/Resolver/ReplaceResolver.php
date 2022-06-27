<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class ReplaceResolver implements ResolverInterface {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function resolve(Asset $asset, string $path): File {
    if (!$asset instanceof File && !$asset instanceof Symlink) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $resolved_asset = clone $asset;
    if (!$this->shouldReplace($path)) {
      $resolved_asset->isVirtual = TRUE;
    }
    return $resolved_asset;
  }

  /**
   * Checks if the asset can be replaced.
   */
  private function shouldReplace(string $path): bool {
    return $this->options->replace ?? ($this->io->getInput()->getOption('dry-run') || $this->confirmReplace($path));
  }

  /**
   * Confirms asset replace.
   */
  private function confirmReplace(string $path): bool {
    return $this->io->confirm("The file <comment>$path</comment> already exists. Would you like to replace it?");
  }

}
