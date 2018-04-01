<?php

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Path processor test.
 *
 * @group DCG
 */
class PathProcessorTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testPathProcessor() {
    $manager = \Drupal::service('path_processor_manager');

    $request = Request::create('/content/1');
    $path = $manager->processInbound('/content/1', $request);
    $this->assertEquals('/node/1', $path);

    $path = $manager->processOutbound('/node/1');
    $this->assertEquals('/content/1', $path);
  }

}
