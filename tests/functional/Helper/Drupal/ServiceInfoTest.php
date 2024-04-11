<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Helper\Drupal;

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
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }
    $service_info = new ServiceInfo(self::bootstrap());

    $service_ids = $service_info->getServicesIds();
    self::assertGreaterThan(545, \count($service_ids));
    self::assertLessThan(575, \count($service_ids));

    // Check if the services are sorted alphabetically.
    $expected_service_ids = [
      'access_arguments_resolver_factory',
      'access_check.admin_menu_block_page',
      'access_check.admin_overview_page',
      'access_check.contact_personal',
      'access_check.cron',
    ];
    self::assertSame($expected_service_ids, \array_slice($service_ids, 0, 5));
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinitions(): void {
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }

    $service_info = new ServiceInfo(self::bootstrap());

    $definitions = $service_info->getServiceDefinitions();
    self::assertGreaterThan(545, \count($definitions));
    self::assertLessThan(575, \count($definitions));

    $expected_service_ids = [
      'access_arguments_resolver_factory',
      'access_check.admin_menu_block_page',
      'access_check.admin_overview_page',
      'access_check.contact_personal',
      'access_check.cron',
    ];
    self::assertSame($expected_service_ids, \array_slice(\array_keys($definitions), 0, 5));

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
        ],
      'arguments_count' => 1,
    ];
    self::assertEquals($expected_definition, $definitions['router.admin_context']);
  }

  /**
   * Test callback.
   */
  public function testGetServiceClasses(): void {
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }
    $service_info = new ServiceInfo(self::bootstrap());

    $classes = $service_info->getServiceClasses();
    self::assertGreaterThan(545, \count($classes));
    self::assertLessThan(575, \count($classes));

    $expected_service_classes = [
      'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
      'access_check.admin_menu_block_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
      'access_check.admin_overview_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
      'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
      'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    ];
    self::assertSame($expected_service_classes, \array_slice($classes, 0, 5));
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinition(): void {
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }
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
  public function testGetServiceMeta(string $id, string $name, string $type_fqn, string $type, ?\LogicException $exception): void {
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
