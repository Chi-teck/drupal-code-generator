<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;

/**
 * Defines a service provider for the Foo module.
 *
 * @see https://www.drupal.org/node/2026959
 */
final class FooServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container): void {
    // @DCG Example of how to register a new service.
    // @code
    //   $container
    //     ->register('foo.example_subscriber', ExampleSubscriber::class)
    //     ->addTag('event_subscriber')
    //     ->addArgument(new Reference('entity_type.manager'));
    // @endcode
  }

}
