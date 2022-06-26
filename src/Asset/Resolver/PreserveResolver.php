<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;

final class PreserveResolver implements ResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): Asset {
    $resolved_asset = clone $asset;
    $resolved_asset->isVirtual = TRUE;
    return $resolved_asset;
  }

}
