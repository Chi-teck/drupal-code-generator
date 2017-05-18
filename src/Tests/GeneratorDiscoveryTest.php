<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\GeneratorDiscovery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test for GeneratorsDiscovery.
 */
class GeneratorsDiscoveryTest extends TestCase {

  const TOTAL_GENERATORS = 15;

  /**
   * Test callback.
   */
  public function testExecute() {
    $discovery = new GeneratorDiscovery(new Filesystem(), '\DrupalCodeGenerator\Commands\Drupal_7');
    $generators = $discovery->getGenerators([DCG_ROOT . '/src/Commands/Drupal_7'], [DCG_ROOT . '/src/Templates']);
    foreach ($generators as $generator) {
      $this->assertInstanceOf('DrupalCodeGenerator\Commands\BaseGenerator', $generator);
    }
    $this->assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
