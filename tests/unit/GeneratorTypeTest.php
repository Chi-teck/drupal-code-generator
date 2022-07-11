<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit;

use DrupalCodeGenerator\GeneratorType;
use PHPUnit\Framework\TestCase;

/**
 * A test for generator type enumeration.
 */
final class GeneratorTypeTest extends TestCase {

  /**
   * Test callback.
   */
  public function testIsNewExtension(): void {
    self::assertTrue(GeneratorType::MODULE->isNewExtension());
    self::assertFalse(GeneratorType::MODULE_COMPONENT->isNewExtension());
    self::assertTrue(GeneratorType::THEME->isNewExtension());
    self::assertFalse(GeneratorType::THEME_COMPONENT->isNewExtension());
    self::assertFalse(GeneratorType::OTHER->isNewExtension());
  }

  /**
   * Test callback.
   */
  public function testGetNameLabel(): void {
    self::assertSame('Module name', GeneratorType::MODULE->getNameLabel());
    self::assertSame('Module name', GeneratorType::MODULE_COMPONENT->getNameLabel());
    self::assertSame('Theme name', GeneratorType::THEME->getNameLabel());
    self::assertSame('Theme name', GeneratorType::THEME_COMPONENT->getNameLabel());
    self::assertSame('Name', GeneratorType::OTHER->getNameLabel());
  }

  /**
   * Test callback.
   */
  public function testGetMachineNameLabel(): void {
    self::assertSame('Module machine name', GeneratorType::MODULE->getMachineNameLabel());
    self::assertSame('Module machine name', GeneratorType::MODULE_COMPONENT->getMachineNameLabel());
    self::assertSame('Theme machine name', GeneratorType::THEME->getMachineNameLabel());
    self::assertSame('Theme machine name', GeneratorType::THEME_COMPONENT->getMachineNameLabel());
    self::assertSame('Machine name', GeneratorType::OTHER->getMachineNameLabel());
  }

}
