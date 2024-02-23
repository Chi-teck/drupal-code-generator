<?php

declare(strict_types=1);

namespace Drupal\foo;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceModifierInterface;

/**
 * Defines a service provider for the Foo module.
 *
 * @see https://www.drupal.org/node/2026959
 */
final class FooServiceProvider implements ServiceModifierInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container): void {
    // @DCG Example of how to swap out existing service.
    // @code
    //   if ($container->hasDefinition('logger.dblog')) {
    //     $container->getDefinition('logger.dblog')
    //       ->setClass(ExampleLogger::class);
    //   }
    // @endcode
  }

}
