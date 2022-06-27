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
  public function testConstructor(?bool $replace): void {
    $options = new DumperOptions($replace);
    self::assertSame($replace, $options->replace);
  }

  /**
   * Data provider callback for testConstructor().
   */
  public function constructorProvider(): array {
    return [
      [TRUE],
      [FALSE],
      [NULL],
    ];
  }

}
