<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\GeneratorDiscovery;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test for GeneratorsDiscovery.
 */
class GeneratorsDiscoveryTest extends \PHPUnit_Framework_TestCase {

  const TOTAL_GENERATORS = 70;

  /**
   * Test callback.
   */
  public function testExecute() {
    $discovery = new GeneratorDiscovery([DCG_ROOT . '/src/Commands'], [DCG_ROOT . '/src/Templates'], new Filesystem());
    $generators = $discovery->getGenerators();
    foreach ($generators as $generator) {
      $this->assertInstanceOf('DrupalCodeGenerator\Commands\BaseGenerator', $generator);
    }
    $this->assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
