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
    $discovery = new GeneratorDiscovery(new Filesystem());
    $generators = $discovery->getGenerators([DCG_ROOT . '/src/Command/Drupal_7'], '\DrupalCodeGenerator\Command\Drupal_7');
    foreach ($generators as $generator) {
      $this->assertInstanceOf('DrupalCodeGenerator\Command\BaseGenerator', $generator);
    }
    $this->assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
