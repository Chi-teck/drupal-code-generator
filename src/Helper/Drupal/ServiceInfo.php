<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A helper that provides information about available Drupal services.
 *
 * @todo Create a test for this.
 */
final class ServiceInfo extends Helper {

  public function __construct(private ContainerInterface $container) {}

  public function getName(): string {
    return 'service_info';
  }

  /**
   * Gets all defined service IDs.
   */
  public function getServicesIds(): array {
    return $this->container->getServiceIds();
  }

  /**
   * Gets all service definitions.
   */
  public function getServiceDefinitions(): ?array {
    $serialized_definitions = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition()['services'];
    return \array_map('unserialize', $serialized_definitions);
  }

  /**
   * Gets service definition.
   */
  public function getServiceDefinition(string $service_id): ?array {
    $serialized_definitions = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition()['services'];
    // @phpcs:disable DrupalPractice.FunctionCalls.InsecureUnserialize.InsecureUnserialize
    return isset($serialized_definitions[$service_id]) ?
      \unserialize($serialized_definitions[$service_id]) : NULL;
  }

}
