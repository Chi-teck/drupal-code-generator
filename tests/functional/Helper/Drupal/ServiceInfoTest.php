<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Tests 'service info' helper.
 */
final class ServiceInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGetName(): void {
    $service_info = new ServiceInfo($this->application->getContainer());
    self::assertSame('service_info', $service_info->getName());
  }

  /**
   * Test callback.
   */
  public function testGetServicesIds(): void {
    $service_info = new ServiceInfo($this->application->getContainer());

    $service_ids = $service_info->getServicesIds();
    self::assertGreaterThan(500, \count($service_ids));
    self::assertLessThan(550, \count($service_ids));

    // Check if the services are sorted alphabetically.
    $expected_service_ids = [
      'access_arguments_resolver_factory',
      'access_check.contact_personal',
      'access_check.cron',
      'access_check.csrf',
      'access_check.custom',
    ];
    self::assertSame($expected_service_ids, \array_slice($service_ids, 0, 5));
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinitions(): void {
    $service_info = new ServiceInfo($this->application->getContainer());

    $definitions = $service_info->getServiceDefinitions();
    self::assertGreaterThan(500, \count($definitions));
    self::assertLessThan(550, \count($definitions));

    $expected_service_ids = [
      'access_arguments_resolver_factory',
      'access_check.contact_personal',
      'access_check.cron',
      'access_check.csrf',
      'access_check.custom',
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
          'resolve' => TRUE,
        ],
      'arguments_count' => 1,
      'properties' => ['_serviceId' => 'router.admin_context'],
    ];
    self::assertEquals($expected_definition, $definitions['router.admin_context']);
  }

  /**
   * Test callback.
   */
  public function testGetServiceDefinition(): void {
    $service_info = new ServiceInfo($this->application->getContainer());

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
      'properties' =>
        [
          '_serviceId' => 'current_route_match',
        ],
    ];
    self::assertEquals($expected_definition, $definition);

    self::expectExceptionObject(new ServiceNotFoundException('unknown_service'));
    $service_info->getServiceDefinition('unknown_service');
  }

}
