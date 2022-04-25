<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\ClassResolver\SimpleClassResolver;
use DrupalCodeGenerator\GeneratorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test for GeneratorsDiscovery.
 *
 * @todo Test required API version and fatal errors.
 */
final class GeneratorFactoryTest extends TestCase {

  private const TOTAL_GENERATORS = 4;

  /**
   * Test callback.
   */
  public function testGetGenerators(): void {
    $logger = new TestLogger();
    $factory = new GeneratorFactory(new SimpleClassResolver(), $logger);
    $generators = $factory->getGenerators(
      [Application::ROOT . '/src/Command/Misc'],
      '\DrupalCodeGenerator\Command\Misc',
    );
    foreach ($generators as $generator) {
      self::assertInstanceOf('DrupalCodeGenerator\Command\Generator', $generator);
    }
    self::assertCount(self::TOTAL_GENERATORS, $generators);

    $log_records[] = [
      'level' => 'debug',
      'message' => 'Total generators: {total}',
      'context' => ['total' => self::TOTAL_GENERATORS],
    ];
    self::assertSame($log_records, $logger->records);
  }

}
