<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;
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
   * Gets a service by name.
   */
  public function getService(string $name): ?object {
    return $this->container->get($name);
  }

  /**
   * Gets all defined service IDs.
   *
   * @psalm-return list<string>
   */
  public function getServicesIds(): array {
    // $this->container->getServiceIds() cannot be used here because it is not
    // defined in the Symfony\Component\DependencyInjection\ContainerInterface.
    $service_ids = \array_keys($this->getServiceDefinitions());
    \sort($service_ids);
    return $service_ids;
  }

  /**
   * Gets all service definitions.
   *
   * @psalm-return array<string, array>
   */
  public function getServiceDefinitions(): array {
    return \array_filter(
      \array_map('unserialize', $this->getSerializedDefinitions()),
      static fn (array $definition, string $id): bool =>
        // Filter out parameters.
        \array_key_exists('class', $definition) &&
        // Filter out Drush services.
        !\str_starts_with(\ltrim($definition['class'], '\\'), 'Drush') &&
        // Filter out aliases.
        // @todo Should we support aliases?
        !\str_contains($id, '\\'),
      \ARRAY_FILTER_USE_BOTH,
    );
  }

  /**
   * Gets all service definitions.
   *
   * @psalm-return array<string, string>
   */
  public function getServiceClasses(): array {
    $service_definitions = $this->getServiceDefinitions();
    /** @psalm-var array<string, class-string> $classes */
    $classes = \array_combine(
      \array_keys($service_definitions),
      \array_column($service_definitions, 'class'),
    );
    return \array_map([Utils::class, 'addLeadingSlash'], $classes);
  }

  /**
   * Gets service definition.
   *
   * @psalm-return array{class: class-string}|null
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
   * Gets metadata for a given service.
   *
   * @todo Add extended description.
   */
  public function getServiceMeta(string $service_id): array {
    $dumped_meta = \json_decode(
      \file_get_contents(Application::ROOT . '/resources/service-meta.json'),
      TRUE,
    );
    // Most used core services are described statically.
    if (\array_key_exists($service_id, $dumped_meta)) {
      $meta = $dumped_meta[$service_id];
    }
    // For services from contrib and custom modules we build meta on demand.
    elseif ($definition = $this->getServiceDefinition($service_id)) {
      $class = $definition['class'];
      /** @psalm-var class-string $interface */
      $interface = $class . 'Interface';
      $meta = [
        'name' => Utils::camelize($service_id, FALSE),
        'type_fqn' => \is_subclass_of($class, $interface) ? $interface : $class,
      ];
    }
    else {
      // @todo Move this exception to ServiceInfo::getServiceDefinition()?
      throw new \LogicException(
        \sprintf('Service "%s" does not exist.', $service_id),
      );
    }

    $type_parts = \explode('\\', $meta['type_fqn']);
    $meta['type'] = \end($type_parts);

    \ksort($meta);
    return $meta;
  }

  /**
   * Returns array of serialized service definitions.
   *
   * @psalm-return array<string, string>
   */
  private function getSerializedDefinitions(): array {
    $cache_definitions = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition();
    $serialized_definitions = $cache_definitions['services'] ?? [];
    \ksort($serialized_definitions);
    return $serialized_definitions;
  }

}
