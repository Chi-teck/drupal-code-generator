<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Asset collection.
 */
final class AssetCollection implements \ArrayAccess, \IteratorAggregate, \Countable {

  /**
   * Assets.
   *
   * @var \DrupalCodeGenerator\Asset\Asset[]
   */
  private array $assets;

  /**
   * AssetCollection constructor.
   *
   * @param \DrupalCodeGenerator\Asset\Asset[] $assets
   *   Assets.
   */
  public function __construct(array $assets = []) {
    $this->assets = $assets;
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function offsetSet($key, $value) {
    if ($key === NULL) {
      $this->assets[] = $value;
    }
    else {
      $this->assets[$key] = $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  #[\ReturnTypeWillChange]
  public function offsetGet($key) {
    if (isset($this->assets[$key])) {
      return $this->assets[$key];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function offsetUnset($key): void {
    unset($this->assets[$key]);
  }

  /**
   * {@inheritdoc}
   */
  public function offsetExists($key): bool {
    return isset($this->assets[$key]);
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator(): \ArrayIterator {
    return new \ArrayIterator($this->assets);
  }

  /**
   * {@inheritdoc}
   */
  public function count(): int {
    return \count($this->assets);
  }

  /**
   * Returns a collection of directory assets.
   */
  public function getDirectories(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof Directory,
    );
    return new self($assets);
  }

  /**
   * Returns a collection of file assets.
   */
  public function getFiles(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof File,
    );
    return new self($assets);
  }

  /**
   * Returns a collection of symlink assets.
   */
  public function getSymlinks(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof Symlink,
    );
    return new self($assets);
  }

  /**
   * Returns a collection of sorted assets.
   */
  public function getSorted(): self {
    $sorter = static function (Asset $a, Asset $b): int {
      $name_a = (string) $a;
      $name_b = (string) $b;

      // Top level assets should go first.
      $result = \strcasecmp(\dirname($name_a), \dirname($name_b));
      if ($result === 0) {
        $result = \strcasecmp($name_a, $name_b);
      }
      return $result;
    };

    $assets = $this->assets;
    \usort($assets, $sorter);
    return new self($assets);
  }

}
