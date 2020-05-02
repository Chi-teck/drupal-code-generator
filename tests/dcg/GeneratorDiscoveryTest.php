<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\GeneratorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Test for GeneratorsDiscovery.
 */
final class GeneratorDiscoveryTest extends TestCase {

  private const TOTAL_GENERATORS = 15;

  /**
   * Test callback.
   */
  public function testExecute(): void {
    $factory = new GeneratorFactory();
    $generators = $factory->getGenerators(
      [Application::ROOT . '/src/Command/Misc/Drupal_7'],
      '\DrupalCodeGenerator\Command\Misc\Drupal_7',
    );
    foreach ($generators as $generator) {
      self::assertInstanceOf('DrupalCodeGenerator\Command\Generator', $generator);
    }
    self::assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
