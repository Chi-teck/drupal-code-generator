<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class SymlinkResolver implements ResolverInterface {

  public function __construct(
    private DumperOptions $options,
    private GeneratorStyleInterface $io,
  ) {}

  public function supports(Asset $asset): bool {
    return $asset instanceof Symlink;
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): ?Symlink {
    /** @var \DrupalCodeGenerator\Asset\Symlink $asset */
    return match (TRUE) {
      $asset->shouldPreserve() => NULL,
      $asset->shouldReplace() => !$this->options->dryRun && !$this->confirmReplace($path) ? NULL : clone $asset,
    };
  }

  /**
   * Confirms symlink replace.
   */
  private function confirmReplace(string $path): bool {
    return $this->options->replace ??
      $this->io->confirm("The symlink <comment>$path</comment> already exists. Would you like to replace it?");
  }

}
