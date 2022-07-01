<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use stdClass;

/**
 * Tests asset collection.
 */
final class AssetCollectionTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testConstructor(): void {
    $collection = new AssetCollection();
    self::assertAssets($collection, []);

    $assets = [
      new Directory('example'),
      new File('foo.txt'),
      new Symlink('foo.link', 'foo.txt'),
    ];
    $collection = new AssetCollection($assets);
    self::assertAssets($collection, $assets);
  }

  /**
   * Test callback.
   */
  public function testAlias(): void {
    $collection = new Assets();
    self::assertInstanceOf(AssetCollection::class, $collection);
  }

  /**
   * Test callback.
   */
  public function testAddDirectory(): void {
    $collection = new AssetCollection();
    $directory = $collection->addDirectory('foo');
    self::assertEquals(new Directory('foo'), $directory);
    self::assertAssets($collection, [new Directory('foo')]);
  }

  /**
   * Test callback.
   */
  public function testAddFile(): void {
    $collection = new AssetCollection();
    $file = $collection->addFile('foo.txt');
    self::assertEquals(new File('foo.txt'), $file);
    self::assertAssets($collection, [new File('foo.txt')]);
  }

  /**
   * Test callback.
   */
  public function testAddSymlink(): void {
    $collection = new AssetCollection();
    $symlink = $collection->addSymlink('foo.link', 'foo.txt');
    self::assertEquals(new Symlink('foo.link', 'foo.txt'), $symlink);
    self::assertAssets($collection, [new Symlink('foo.link', 'foo.txt')]);
  }

  /**
   * Test callback.
   */
  public function testAddSchemaFile(): void {
    $collection = new AssetCollection();
    $file = $collection->addSchemaFile('schema.yml');
    $expected_file = File::create('schema.yml')->appendIfExists();
    self::assertEquals($expected_file, $file);

    // Test default path.
    $collection = new AssetCollection();
    $file = $collection->addSchemaFile();
    $expected_file = File::create('config/schema/{machine_name}.schema.yml')->appendIfExists();
    self::assertEquals($expected_file, $file);
    self::assertAssets($collection, [$expected_file]);
  }

  /**
   * Test callback.
   */
  public function testAddServicesFile(): void {
    $collection = new AssetCollection();
    $file = $collection->addServicesFile('foo/services.yml');
    $expected_file = File::create('foo/services.yml')->appendIfExists(1);
    self::assertEquals($expected_file, $file);

    // Test default path.
    $collection = new AssetCollection();
    $file = $collection->addServicesFile();
    $expected_file = File::create('{machine_name}.services.yml')->appendIfExists(1);
    self::assertEquals($expected_file, $file);
    self::assertAssets($collection, [$expected_file]);
  }

  /**
   * Test callback.
   */
  public function testArrayInterfaces(): void {
    // Test countable.
    $collection = new AssetCollection();
    self::assertTrue(\is_countable($collection));
    self::assertCount(0, $collection);

    // Test iterable.
    $collection = new AssetCollection([
      new Directory('example'),
      new File('foo.txt'),
      new Symlink('foo.link', 'foo.txt'),
    ]);
    self::assertIsIterable($collection);
    $expected_assets = [
      new Directory('example'),
      new File('foo.txt'),
      new Symlink('foo.link', 'foo.txt'),
    ];
    $counter = 0;
    foreach ($collection as $index => $asset) {
      self::assertEquals($expected_assets[$index], $asset);
      $counter++;
    }
    self::assertSame(\count($expected_assets), $counter);

    // Test array access.
    $collection = new AssetCollection();
    self::assertInstanceOf(\ArrayAccess::class, $collection);
    $collection[] = new Directory('example');
    $collection[] = new File('foo.txt');
    $collection[] = new Symlink('foo.link', 'foo.txt');
    self::assertCount(3, $collection);
    self::assertTrue(isset($collection[2]));
    unset($collection[2]);
    self::assertCount(2, $collection);
    self::assertFalse(isset($collection[2]));
  }

  /**
   * Test callback.
   */
  public function testSupportedTypes(): void {
    $collection = new AssetCollection();
    $collection[] = new Directory('foo');
    $collection[] = new File('foo.txt');
    $collection[] = new Symlink('foo.link', 'foo.txt');
    self::expectExceptionObject(new \InvalidArgumentException('Unsupported asset type.'));
    $collection[] = new stdClass();
  }

  /**
   * Test callback.
   */
  public function testGetDirectories(): void {
    $collection = new AssetCollection([
      new Directory('example-1'),
      new File('foo.txt'),
      new Directory('example-2'),
      new Symlink('foo.link', 'foo.txt'),
      new Directory('example-3'),
    ]);
    $directory_collection = $collection->getDirectories();
    self::assertCount(3, $directory_collection);
    $expected_assets = [
      new Directory('example-1'),
      new Directory('example-2'),
      new Directory('example-3'),
    ];
    self::assertAssets($directory_collection, $expected_assets);
  }

  /**
   * Test callback.
   */
  public function testGetFiles(): void {
    $collection = new AssetCollection([
      new File('example-1.txt'),
      new Directory('foo/bar'),
      new File('example-2.txt'),
      new Symlink('foo.link', 'foo.txt'),
      new File('example-3.txt'),
    ]);
    $file_collection = $collection->getFiles();
    self::assertCount(3, $file_collection);
    $expected_assets = [
      new File('example-1.txt'),
      new File('example-2.txt'),
      new File('example-3.txt'),
    ];
    self::assertAssets($file_collection, $expected_assets);
  }

  /**
   * Test callback.
   */
  public function testGetSymlinks(): void {
    $collection = new AssetCollection([
      new Symlink('example-1.link', 'example-1.txt'),
      new Directory('foo/bar'),
      new Symlink('example-2.link', 'example-2.txt'),
      new File('foo.txt'),
      new Symlink('example-3.link', 'example-3.txt'),
    ]);
    $file_collection = $collection->getSymlinks();
    self::assertCount(3, $file_collection);
    $expected_assets = [
      new Symlink('example-1.link', 'example-1.txt'),
      new Symlink('example-2.link', 'example-2.txt'),
      new Symlink('example-3.link', 'example-3.txt'),
    ];
    self::assertAssets($file_collection, $expected_assets);
  }

  /**
   * Test callback.
   */
  public function testGetSorted(): void {
    $collection = new AssetCollection([
      new File('foo/bar/example-1.txt'),
      new File('foo/bar/example-2.txt'),
      new File('foo/example-1.txt'),
      new File('foo/example-2.txt'),
      new File('example-2.txt'),
      new File('example-1.txt'),
    ]);
    $expected_assets = [
      new File('example-1.txt'),
      new File('example-2.txt'),
      new File('foo/example-1.txt'),
      new File('foo/example-2.txt'),
      new File('foo/bar/example-1.txt'),
      new File('foo/bar/example-2.txt'),
    ];
    $sorted_collection = $collection->getSorted();
    self::assertAssets($sorted_collection, $expected_assets);
  }

  /**
   * Asserts assets in a collection.
   */
  private static function assertAssets(AssetCollection $collection, array $expected_assets): void {
    self::assertEquals($expected_assets, \iterator_to_array($collection));
  }

}
