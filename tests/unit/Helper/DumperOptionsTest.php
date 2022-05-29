<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper;

use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;

/**
 * A test for Dumper helper.
 */
final class DumperOptionsTest extends BaseTestCase {

  /**
   * Test callback.
   *
   * @dataProvider constructorProvider()
   */
  public function testConstructor(?bool $replace, bool $dry_run, bool $full_path): void {
    $options = new DumperOptions($replace, $dry_run, $full_path);
    self::assertSame($replace, $options->replace);
    self::assertSame($dry_run, $options->dryRun);
    self::assertSame($full_path, $options->fullPath);
  }

  /**
   * Data provider callback for testConstructor().
   */
  public function constructorProvider(): array {
    return [
      [TRUE, TRUE, TRUE],
      [FALSE, FALSE, FALSE],
      [NULL, FALSE, FALSE],
    ];
  }

}
