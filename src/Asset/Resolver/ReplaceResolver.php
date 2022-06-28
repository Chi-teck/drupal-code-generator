<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

final class ReplaceResolver implements ResolverInterface {

  public function __construct(readonly private GeneratorStyleInterface $io) {}

  public function resolve(Asset $asset, string $path): NULL|File|Symlink {
    if (!$asset instanceof File && !$asset instanceof Symlink) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }

    $replace = $this->io->getInput()->getOption('replace') ||
               $this->io->getInput()->getOption('dry-run') ||
               $this->io->confirm("The file <comment>$path</comment> already exists. Would you like to replace it?");

    return $replace ? clone $asset : NULL;
  }

}
