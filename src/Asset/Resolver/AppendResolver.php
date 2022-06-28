<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Style\GeneratorStyle;

final class AppendResolver implements ResolverInterface, ResolverFactoryInterface {

  public function __construct(readonly private int $headerSize = 0) {
    if ($headerSize < 0) {
      throw new \InvalidArgumentException('Header size must be greater than or equal to 0.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function createResolver(GeneratorStyle $io, mixed $options): self {
    return new self($options);
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): Asset {
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
