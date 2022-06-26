<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;

final class DirectoryResolver implements ResolverInterface {

  public function resolve(Asset $asset, string $path): Directory {
    if (!$asset instanceof Directory) {
      throw new \InvalidArgumentException('Wrong asset type.');
    }
    return clone $asset->skipIfExists();
  }

}
