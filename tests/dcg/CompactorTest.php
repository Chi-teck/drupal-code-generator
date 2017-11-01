<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Box\PhpCompactor;
use PHPUnit\Framework\TestCase;

/**
 * A test for PHP compactor.
 */
class CompactorTest extends TestCase {

  /**
   * Test callback.
   */
  public function testCompactor() {
    // Define base class for PhpCompactor as it may not exist.
    if (!class_exists('Herrera\Box\Compactor\Compactor')) {
      // @codingStandardsIgnoreLine
      eval('namespace Herrera\Box\Compactor; class Compactor {}');
    }
    $code = "<?php\n// Comment.\nif (TRUE) {\n  echo 'bar';\n}\n";
    static::assertEquals(
      "<?php\nif (TRUE) { echo 'bar'; } ",
      (new PhpCompactor())->compact($code)
    );
  }

}
