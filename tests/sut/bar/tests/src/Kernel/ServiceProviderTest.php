<?php declare(strict_types = 1);

namespace Drupal\Tests\bar\Kernel;

use Drupal\bar\BarServiceProvider;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\KernelTests\KernelTestBase;

/**
 * A test for service provider.
 *
 * @group DCG
 */
final class ServiceProviderTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['bar'];

  /**
   * Test callback.
   */
  public function testServiceProvider(): void {
    $provider = $this->container
      ->get('kernel')
      ->getServiceProviders('app')['bar'];
    self::assertInstanceOf(BarServiceProvider::class, $provider);
    self::assertInstanceOf(ServiceProviderInterface::class, $provider);
    self::assertInstanceOf(ServiceModifierInterface::class, $provider);
  }

}
