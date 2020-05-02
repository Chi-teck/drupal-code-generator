<?php

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
  private $assets;

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
      static function ($asset): bool {
        return $asset instanceof Directory;
      }
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
      static function ($asset): bool {
        return $asset instanceof File;
      }
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
      static function ($asset): bool {
        return $asset instanceof Symlink;
      }
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
      $depth_a = \substr_count($a, '/');
      $depth_b = \substr_count($b, '/');
      // Top level assets should be printed first.
      return $depth_a == $depth_b || ($depth_a > 1 && $depth_b > 1) ?
        \strcmp($a, $b) : ($depth_a > $depth_b ? 1 : -1);
    });
    return new self($assets);
  }

}
