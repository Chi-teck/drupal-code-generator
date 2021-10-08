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
   * Returns directory assets.
   *
   * @return self
   *   Collection of directory assets.
   */
  public function getDirectories(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof Directory,
    );
    return new self($assets);
  }

  /**
   * Returns file assets.
   *
   * @return self
   *   Collection of file assets.
   */
  public function getFiles(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof File,
    );
    return new self($assets);
  }

  /**
   * Returns symlink assets.
   *
   * @return self
   *   Collection of symlink assets.
   */
  public function getSymlinks(): self {
    $assets = \array_filter(
      $this->assets,
      static fn ($asset): bool => $asset instanceof Symlink,
    );
    return new self($assets);
  }

  /**
   * Returns directory assets.
   *
   * @return self
   *   Collection of sorted assets.
   */
  public function getSorted(): self {
    $assets = $this->assets;
    \usort($assets, static function (Asset $a, Asset $b): int {
      $name_a = (string) $a;
      $name_b = (string) $b;
      $depth_a = \substr_count($name_a, '/');
      $depth_b = \substr_count($name_b, '/');
      // Top level assets should be printed first.
      return $depth_a === $depth_b || \min($depth_a, $depth_b) > 1 ?
        \strcmp($name_a, $name_b) : $depth_a <=> $depth_b;
    });
    return new self($assets);
  }

}
