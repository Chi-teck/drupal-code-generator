<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Other;
use DrupalCodeGenerator\GeneratorsDiscovery;
use DrupalCodeGenerator\Commands;
use Symfony\Component\Filesystem\Filesystem;

class GeneratorsDiscoveryTest extends \PHPUnit_Framework_TestCase {

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
    $this->assertCount(18, $generators);
  }

}
