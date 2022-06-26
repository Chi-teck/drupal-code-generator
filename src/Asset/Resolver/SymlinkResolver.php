<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class SymlinkResolver implements ResolverInterface {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): Symlink {
    if (!$asset instanceof Symlink) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $asset = clone $asset;
    return match (TRUE) {
      $asset->shouldPreserve() => $asset,
      $asset->shouldReplace() => $this->shouldReplace($path) ? $asset->replaceIfExists() : $asset,
    };
  }

  /**
   * Checks if the symlink can be replaced.
   */
  private function shouldReplace(string $path): bool {
    return $this->options->replace ?? ($this->options->dryRun || $this->confirmReplace($path));
  }

  /**
   * Confirms symlink replace.
   */
  private function confirmReplace(string $path): bool {
    return $this->io->confirm("The symlink <comment>$path</comment> already exists. Would you like to replace it?");
  }

}
