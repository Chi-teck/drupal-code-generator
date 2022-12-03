<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\InputOutput\IO;

final class ReplaceResolver implements ResolverInterface, ResolverFactoryInterface {

  /**
   * Constructs the object.
   */
  public function __construct(private readonly IO $io) {}

  /**
   * {@inheritdoc}
   */
  public static function createResolver(IO $io, mixed $options): self {
    return new self($io);
  }

  /**
   * {@inheritdoc}
   */
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
