<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A helper that provides information about available Drupal services.
 */
final class ServiceInfo extends Helper {

  /**
   * Constructs the helper.
   */
  public function __construct(private readonly ContainerInterface $container) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'service_info';
  }

  /**
   * Gets all defined service IDs.
   */
  public function getServicesIds(): array {
    $service_ids = $this->container->getServiceIds();
    \sort($service_ids);
    return $service_ids;
  }

  /**
   * Gets all service definitions.
   */
  public function getServiceDefinitions(): array {
    return \array_map('unserialize', $this->getSerializedDefinitions());
  }

  /**
   * Gets service definition.
   */
  public function getServiceDefinition(string $service_id): ?array {
    $serialized_definitions = $this->getSerializedDefinitions();
    if (!\array_key_exists($service_id, $serialized_definitions)) {
      return NULL;
    }
    // @phpcs:ignore DrupalPractice.FunctionCalls.InsecureUnserialize.InsecureUnserialize
    return \unserialize($serialized_definitions[$service_id]);
  }

  /**
   * Returns array of serialized service definitions.
   */
  private function getSerializedDefinitions(): array {
    $serialized_definitions = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition()['services'];
    \ksort($serialized_definitions);
    return $serialized_definitions;
  }

}
