<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\ClassResolver\SimpleClassResolver;
use DrupalCodeGenerator\GeneratorFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

/**
 * Test for GeneratorsDiscovery.
 *
 * @todo Test required API version and fatal errors.
 */
final class GeneratorFactoryTest extends TestCase {

  private const TOTAL_GENERATORS = 15;

  /**
   * Test callback.
   */
  public function testGetGenerators(): void {
    $logger = new TestLogger();
    $factory = new GeneratorFactory(new SimpleClassResolver(), $logger);
    $generators = $factory->getGenerators(
      [Application::ROOT . '/src/Command/Misc/Drupal_7'],
      '\DrupalCodeGenerator\Command\Misc\Drupal_7',
    );
    foreach ($generators as $generator) {
      self::assertInstanceOf('DrupalCodeGenerator\Command\Generator', $generator);
    }
    self::assertCount(self::TOTAL_GENERATORS, $generators);

    self::assertTrue($logger->hasDebugThatMatches('/^Total generators: {total}/'));
  }

}
