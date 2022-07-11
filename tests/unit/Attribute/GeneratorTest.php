<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Attribute;

use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\GeneratorType;
use PHPUnit\Framework\TestCase;

/**
 * A test for generator definition.
 */
final class GeneratorTest extends TestCase {

  /**
   * Test callback.
   */
  public function testDefinition(): void {
    $definition = new GeneratorDefinition(
      name: 'example',
      description: 'Generates examples',
      aliases: ['foo'],
      hidden: TRUE,
      templatePath: 'templates',
      type: GeneratorType::MODULE,
      label: 'Example',
    );
    self::assertSame('example', $definition->name);
    self::assertSame('Generates examples', $definition->description);
    self::assertSame(['foo'], $definition->aliases);
    self::assertTrue($definition->hidden);
    self::assertSame('templates', $definition->templatePath);
    self::assertSame(GeneratorType::MODULE, $definition->type);
    self::assertSame('Example', $definition->label);
  }

  /**
   * Test callback.
   */
  public function testDefaults(): void {
    $definition = new GeneratorDefinition('example');
    self::assertSame('example', $definition->name);
    self::assertNull($definition->description);
    self::assertSame([], $definition->aliases);
    self::assertFalse($definition->hidden);
    self::assertNull($definition->templatePath);
    self::assertSame(GeneratorType::OTHER, $definition->type);
    self::assertNull($definition->label);
  }

}
