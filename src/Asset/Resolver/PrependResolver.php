<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;

final class PrependResolver implements ResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): Asset {
    if (!$asset instanceof File) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $resolved_asset = clone $asset;
    $new_content = $resolved_asset->getContent();
    $existing_content = \file_get_contents($path);
    $resolved_asset->content($new_content . "\n" . $existing_content);
    return $resolved_asset;
  }

}
