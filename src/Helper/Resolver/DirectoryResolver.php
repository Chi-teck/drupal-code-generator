<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Resolver;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;

final class DirectoryResolver implements ResolverInterface {

  public function supports(Asset $asset): bool {
    return $asset instanceof Directory;
  }

  public function resolve(Asset $asset, string $path): ?Directory {
    // Recreating directories makes no sense.
    return NULL;
  }

}
