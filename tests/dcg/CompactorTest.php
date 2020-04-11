<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Box\PhpCompactor;
use PHPUnit\Framework\TestCase;

/**
 * A test for PHP compactor.
 */
final class CompactorTest extends TestCase {

  /**
   * Test callback.
   */
  public function testCompactor(): void {
    // Define base class for PhpCompactor as it may not exist.
    if (!class_exists('Herrera\Box\Compactor\Compactor')) {
      // @codingStandardsIgnoreLine
      eval('namespace Herrera\Box\Compactor; class Compactor {}');
    }
    $code_before = <<< 'EOT'
      <?php
      // Comment.
      if (TRUE) {
        echo 'bar';
      }

      EOT;

    $code_after = <<< 'EOT'
      <?php
      if (TRUE) { echo 'bar'; } 
      EOT;

    self::assertSame($code_after, (new PhpCompactor())->compact($code_before));
  }

}
