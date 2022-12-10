<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\InputOutput\IO;

final class AppendResolver implements ResolverInterface, ResolverFactoryInterface {

  /**
   * Constructs the object.
   *
   * @psalm-param int<0, max> $headerSize
   */
  public function __construct(private readonly int $headerSize = 0) {
    /** @psalm-suppress DocblockTypeContradiction */
    if ($headerSize < 0) {
      throw new \InvalidArgumentException('Header size must be greater than or equal to 0.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function createResolver(IO $io, mixed $options): self {
    return new self($options);
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): File {
    if (!$asset instanceof File) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $new_content = $asset->getContent();
    // Remove header from existing content.
    if ($this->headerSize > 0) {
      $new_content = \implode("\n", \array_slice(\explode("\n", $new_content), $this->headerSize));
    }
    $existing_content = \file_get_contents($path);
    return clone $asset->content($existing_content . "\n" . $new_content);
  }

}
