<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use Drupal\Core\CronInterface;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Tests 'service info' helper.
 */
final class ServiceInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGetName(): void {
    $service_info = new ServiceInfo(self::bootstrap());
    self::assertSame('service_info', $service_info->getName());
  }

  /**
   * Test callback.
   */
  public function testGetService(): void {
    $service_info = new ServiceInfo(self::bootstrap());
    self::assertInstanceOf(CronInterface::class, $service_info->getService('cron'));
  }

  /**
   * Test callback.
   */
  public function testGetServicesIds(): void {
    // @todo Remove this once we drop support form Drupal 10.0.
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.0')) {
      self::markTestSkipped();
    }
    $service_info = new ServiceInfo(self::bootstrap());

    $service_ids = $service_info->getServicesIds();
    self::assertGreaterThan(500, \count($service_ids));
    self::assertLessThan(550, \count($service_ids));

    // Check if the services are sorted alphabetically.
    $expected_service_ids = [
      'Drupal\Component\DependencyInjection\ReverseContainer',
      'Drupal\Core\Access\CheckProviderInterface',
      'Drupal\Core\Config\StorageManagerInterface',
      'Drupal\Core\Form\FormCacheInterface',
      'Drupal\Core\Http\HandlerStackConfigurator',
      'Drupal\Core\Menu\MenuTreeStorageInterface',
    ];
    self::assertSame($expected_service_ids, \array_slice($service_ids, 0, 6));
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinitions(): void {
    // @todo Remove this once we drop support form Drupal 10.0.
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.0')) {
      self::markTestSkipped();
    }
    $service_info = new ServiceInfo(self::bootstrap());

    $definitions = $service_info->getServiceDefinitions();
    self::assertGreaterThan(500, \count($definitions));
    self::assertLessThan(550, \count($definitions));

    $expected_service_ids = [
      'Drupal\Component\DependencyInjection\ReverseContainer',
      'Drupal\Core\Access\CheckProviderInterface',
      'Drupal\Core\Config\StorageManagerInterface',
      'Drupal\Core\Form\FormCacheInterface',
      'Drupal\Core\Http\HandlerStackConfigurator',
      'Drupal\Core\Menu\MenuTreeStorageInterface',
    ];
    self::assertSame($expected_service_ids, \array_slice(\array_keys($definitions), 0, 6));

    $expected_definition = [
      'class' => 'Drupal\\Core\\Routing\\AdminContext',
      'arguments' =>
        // @phpcs:ignore Drupal.Arrays.Array.ArrayIndentation
        (object) [
          'type' => 'collection',
          'value' =>
            [
              (object) [
                'type' => 'service',
                'id' => 'current_route_match',
                'invalidBehavior' => 1,
              ],
            ],
          'resolve' => TRUE,
        ],
      'arguments_count' => 1,
    ];
    self::assertEquals($expected_definition, $definitions['router.admin_context']);
  }

  /**
   * Test callback.
   */
  public function testGetServiceClasses(): void {
    // @todo Remove this once we drop support form Drupal 10.0.
    if (\str_starts_with(\getenv('DCG_DRUPAL_VERSION') ?: '', '10.0')) {
      self::markTestSkipped();
    }
    $service_info = new ServiceInfo(self::bootstrap());

    $classes = $service_info->getServiceClasses();
    self::assertGreaterThan(500, \count($classes));
    self::assertLessThan(550, \count($classes));

    $expected_service_ids = [
      'Drupal\Component\DependencyInjection\ReverseContainer' => '\Drupal\Component\DependencyInjection\ReverseContainer',
      'Drupal\Core\Access\CheckProviderInterface' => '\Drupal\Core\Access\CheckProvider',
      'Drupal\Core\Config\StorageManagerInterface' => '\Drupal\Core\Config\ExportStorageManager',
      'Drupal\Core\Form\FormCacheInterface' => '\Drupal\Core\Form\FormCache',
      'Drupal\Core\Http\HandlerStackConfigurator' => '\Drupal\Core\Http\HandlerStackConfigurator',
      'Drupal\Core\Menu\MenuTreeStorageInterface' => '\Drupal\Core\Menu\MenuTreeStorage',
    ];
    self::assertSame($expected_service_ids, \array_slice($classes, 0, 6));
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinition(): void {
    $service_info = new ServiceInfo(self::bootstrap());

    $definition = $service_info->getServiceDefinition('current_route_match');
    $expected_definition = [
      'class' => 'Drupal\\Core\\Routing\\CurrentRouteMatch',
      'arguments' =>
        // @phpcs:ignore Drupal.Arrays.Array.ArrayIndentation
        (object) [
          'type' => 'collection',
          'value' =>
            [
              (object) [
                'type' => 'service',
                'id' => 'request_stack',
                'invalidBehavior' => 1,
              ],
            ],
          'resolve' => TRUE,
        ],
      'arguments_count' => 1,
    ];
    self::assertEquals($expected_definition, $definition);

    $definition = $service_info->getServiceDefinition('unknown_service');
    self::assertNull($definition);
  }

  /**
   * Test callback.
   *
   * @dataProvider serviceMetaProvider
   */
  public function testGetServiceMeta(string $id, string $name, string $type_fqn, string $type, ?\Exception $exception): void {
    $service_info = new ServiceInfo(self::bootstrap());

    if ($exception) {
      self::expectExceptionObject($exception);
    }
    $meta = $service_info->getServiceMeta($id);

    $expected = [
      'name' => $name,
      'type' => $type,
      'type_fqn' => $type_fqn,
    ];
    self::assertSame($expected, $meta);
  }

  /**
   * Data provider for testGetServiceMeta().
   */
  public function serviceMetaProvider(): array {

    $data[] = [
      'entity_type.manager',
      'entityTypeManager',
      'Drupal\Core\Entity\EntityTypeManagerInterface',
      'EntityTypeManagerInterface',
      NULL,
    ];

    $data[] = [
      'views.views_data_helper',
      'viewsViewsDataHelper',
      'Drupal\views\ViewsDataHelper',
      'ViewsDataHelper',
      NULL,
    ];

    $data[] = [
      'not.exists',
      'render_placeholder_generator',
      'Drupal\Core\EventSubscriber\AuthenticationSubscriber',
      'AuthenticationSubscriber',
      new \LogicException('Service "not.exists" does not exist.'),
    ];

    return $data;
  }

}
