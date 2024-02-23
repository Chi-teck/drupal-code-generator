<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Asset collection.
 *
 * @template-implements \ArrayAccess<string,\DrupalCodeGenerator\Asset\Asset>
 * @template-implements \IteratorAggregate<string,\DrupalCodeGenerator\Asset\Asset>
 */
final class AssetCollection implements \ArrayAccess, \IteratorAggregate, \Countable, \Stringable {

  /**
   * AssetCollection constructor.
   *
   * @param \DrupalCodeGenerator\Asset\Asset[] $assets
   *   Assets.
   */
  public function __construct(private array $assets = []) {}

  /**
   * Creates a directory asset.
   */
  public function addDirectory(string $path): Directory {
    $directory = new Directory($path);
    $this->assets[] = $directory;
    return $directory;
  }

  /**
   * Creates a file asset.
   */
  public function addFile(string $path, ?string $template = NULL): File {
    $file = new File($path);
    if ($template) {
      $file->template($template);
    }
    $this->assets[] = $file;
    return $file;
  }

  /**
   * Creates a symlink asset.
   *
   * @noinspection PhpUnused
   */
  public function addSymlink(string $path, string $target): Symlink {
    $symlink = new Symlink($path, $target);
    $this->assets[] = $symlink;
    return $symlink;
  }

  /**
   * Adds an asset for configuration schema file.
   */
  public function addSchemaFile(string $path = 'config/schema/{machine_name}.schema.yml'): File {
    return $this->addFile($path)
      ->appendIfExists();
  }

  /**
   * Adds an asset for service file.
   */
  public function addServicesFile(string $path = '{machine_name}.services.yml'): File {
    return $this->addFile($path)
      ->appendIfExists(1);
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-param \DrupalCodeGenerator\Asset\Asset $value
   */
  public function offsetSet(mixed $offset, mixed $value): void {
    match (TRUE) {
      $value instanceof Directory,
      $value instanceof File,
      $value instanceof Symlink => NULL,
      default => throw new \InvalidArgumentException('Unsupported asset type.'),
    };
    if ($offset === NULL) {
      $this->assets[] = $value;
    }
    else {
      $this->assets[$offset] = $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function offsetGet(mixed $offset): ?Asset {
    return $this->assets[$offset] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function offsetUnset(mixed $offset): void {
    unset($this->assets[$offset]);
  }

  /**
   * {@inheritdoc}
   */
  public function offsetExists(mixed $offset): bool {
    return isset($this->assets[$offset]);
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator(): \ArrayIterator {
    return new \ArrayIterator($this->assets);
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-return int<0, max>
   */
  public function count(): int {
    return \count($this->assets);
  }

  /**
   * Returns a collection of directory assets.
   */
  public function getDirectories(): self {
    return $this->getFiltered(
      static fn (Asset $asset): bool => $asset instanceof Directory,
    );
  }

  /**
   * Returns a collection of file assets.
   */
  public function getFiles(): self {
    return $this->getFiltered(
      static fn (Asset $asset): bool => $asset instanceof File,
    );
  }

  /**
   * Returns a collection of symlink assets.
   */
  public function getSymlinks(): self {
    return $this->getFiltered(
      static fn (Asset $asset): bool => $asset instanceof Symlink,
    );
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

  /**
   * Filters the asset collection.
   */
  public function getFiltered(callable $filter): self {
    $iterator = new \CallbackFilterIterator($this->getIterator(), $filter);
    $assets = \iterator_to_array($iterator);
    $str_keys = \array_filter(\array_keys($assets), 'is_string');
    // Reindex if it's not an associative array.
    return new self(\count($str_keys) > 0 ? $assets : \array_values($assets));
  }

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    $output = '';
    foreach ($this->getSorted() as $asset) {
      $output .= '• ' . $asset . \PHP_EOL;
    }
    return $output;
  }

}
