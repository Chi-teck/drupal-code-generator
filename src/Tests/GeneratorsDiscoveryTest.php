<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands;
use DrupalCodeGenerator\Commands\Other;
use DrupalCodeGenerator\GeneratorsDiscovery;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test for GeneratorsDiscovery.
 */
class GeneratorsDiscoveryTest extends \PHPUnit_Framework_TestCase {

  const TOTAL_GENERATORS = 20;

  /**
   * Test callback.
   */
  public function testExecute() {
    $filesystem = new Filesystem();
    $twig_loader = new \Twig_Loader_Filesystem(DCG_ROOT . '/src/Resources/templates');
    $twig = new \Twig_Environment($twig_loader);
    $discovery = new GeneratorsDiscovery([DCG_ROOT . '/src/Commands'], $filesystem, $twig);
    $generators = $discovery->getGenerators();
    foreach ($generators as $generator) {
      $this->assertInstanceOf('DrupalCodeGenerator\Commands\BaseGenerator', $generator);
    }
    $this->assertCount(self::TOTAL_GENERATORS, $generators);
  }

}
