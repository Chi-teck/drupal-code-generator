<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;

final class PreserveResolver implements ResolverInterface {

  /**
   * {@inheritdoc}
   *
   * @psalm-return null
   */
  public function resolve(Asset $asset, string $path): ?Asset {
    return NULL;
  }

}
