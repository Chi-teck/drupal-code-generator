<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Resolver;

use DrupalCodeGenerator\Asset\Asset;

final class ChainedResolver implements ResolverInterface {

  readonly private array $resolvers;

  public function __construct(ResolverInterface ...$resolvers) {
    $this->resolvers = $resolvers;
  }

  public function supports(Asset $asset): bool {
    return $this->getResolver($asset) !== NULL;
  }

  public function resolve(Asset $asset, string $path): ?Asset {
    $resolver = $this->getResolver($asset);
    if ($resolver === NULL) {
      throw new \LogicException('Unsupported asset type.');
    }
    return $resolver->resolve($asset, $path);
  }

  private function getResolver(Asset $asset): ?ResolverInterface {
    foreach ($this->resolvers as $resolver) {
      if ($resolver->supports($asset)) {
        return $resolver;
      }
    }
    return NULL;
  }

}
