<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;

final class PrependResolver implements ResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): File {
    if (!$asset instanceof File) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $new_content = $asset->getContent();
    $existing_content = \file_get_contents($path);
    return clone $asset->content($new_content . "\n" . $existing_content);
  }

}
