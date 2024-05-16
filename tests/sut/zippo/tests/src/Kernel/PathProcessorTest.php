<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Request;

/**
 * Path processor test.
 */
#[Group('DCG')]
final class PathProcessorTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testPathProcessor(): void {
    $manager = $this->container->get('path_processor_manager');

    $request = Request::create('/conTent/1');
    $path = $manager->processInbound('/conTent/1', $request);
    self::assertSame('/node/1', $path);

    $path = $manager->processOutbound('/noDe/1');
    self::assertSame('/content/1', $path);
  }

}
