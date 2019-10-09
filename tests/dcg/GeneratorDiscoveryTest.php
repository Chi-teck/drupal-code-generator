<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\GeneratorFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test for GeneratorsDiscovery.
 */
class GeneratorDiscoveryTest extends TestCase {

  const TOTAL_GENERATORS = 15;

  /**
   * Test callback.
   */
  public function testExecute(): void {
    $factory = new GeneratorFactory(new Filesystem());
    $generators = $factory->getGenerators(
      [Application::ROOT . '/src/Command/Misc/Drupal_7'],
      '\DrupalCodeGenerator\Command\Misc\Drupal_7'
    );
    foreach ($generators as $generator) {
      static::assertInstanceOf('DrupalCodeGenerator\Command\Generator', $generator);
    }
    static::assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
