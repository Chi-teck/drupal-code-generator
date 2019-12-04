<?php

namespace DrupalCodeGenerator\Asset;

use function array_filter;
use function strcmp;
use function substr_count;
use function usort;

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
  public function offsetUnset($key) {
    unset($this->assets[$key]);
  }

  /**
   * {@inheritdoc}
   */
  public function offsetExists($key) {
    return isset($this->assets[$key]);
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->assets);
  }

  /**
   * {@inheritdoc}
   */
  public function count() {
    return count($this->assets);
  }

  /**
   * Returns file assets.
   *
   * @return \DrupalCodeGenerator\Asset\File[]
   *   Array of file assets.
   */
  public function getFiles(): array {
    return array_filter(
      $this->assets,
      function ($asset): bool {
        return $asset instanceof File;
      }
    );
  }

  /**
   * Returns directory assets.
   *
   * @return \DrupalCodeGenerator\Asset\Directory[]
   *   Array of directory assets.
   */
  public function getDirectories(): array {
    return array_filter(
      $this->assets,
      function ($asset): bool {
        return $asset instanceof Directory;
      }
    );
  }

  /**
   * Returns directory assets.
   *
   * @return \DrupalCodeGenerator\Asset\Asset[]
   *   Array of directory assets.
   */
  public function getSorted(): self {
    $assets = $this->assets;
    usort($assets, function (Asset $a, Asset $b): int {
      $depth_a = substr_count($a, '/');
      $depth_b = substr_count($b, '/');
      // Top level files should be printed first.
      return $depth_a == $depth_b || ($depth_a > 1 && $depth_b > 1) ?
        strcmp($a, $b) : ($depth_a > $depth_b ? 1 : -1);
    });
    return new self($assets);
  }

}
