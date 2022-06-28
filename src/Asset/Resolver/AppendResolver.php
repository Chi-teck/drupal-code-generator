<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;

final class AppendResolver implements ResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function resolve(Asset $asset, string $path): Asset {
    if (!$asset instanceof File) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    $resolved_asset = clone $asset;
    $new_content = $resolved_asset->getContent();
    $header_size = $resolved_asset->getHeaderSize();
    // Remove header from existing content.
    if ($header_size > 0) {
      $new_content = \implode("\n", \array_slice(\explode("\n", $new_content), $header_size));
    }
    $existing_content = \file_get_contents($path);
    $resolved_asset->content($existing_content . "\n" . $new_content);
    return $resolved_asset;
  }

}
