<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit;

use DrupalCodeGenerator\GeneratorType;
use PHPUnit\Framework\TestCase;

/**
 * A test for generator type enumeration.
 */
final class GeneratorTypeTest extends TestCase {

  public function testGeneratorType(): void {
    self::assertTrue(GeneratorType::MODULE->isNewExtension());
    self::assertFalse(GeneratorType::MODULE_COMPONENT->isNewExtension());
    self::assertTrue(GeneratorType::THEME->isNewExtension());
    self::assertFalse(GeneratorType::THEME_COMPONENT->isNewExtension());
    self::assertFalse(GeneratorType::OTHER->isNewExtension());
  }

}
