<?php

declare(strict_types=1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\yety\Example;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests services.yml.
 */
#[Group('DCG')]
final class ServicesTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * Test callback.
   */
  public function testServices(): void {
    $example = $this->container->get('yety.example');
    self::assertInstanceOf(Example::class, $example);
    $definition = $example->getDefinition('entity_view_mode');
    self::assertSame('View mode', (string) $definition->getLabel());
  }

}
