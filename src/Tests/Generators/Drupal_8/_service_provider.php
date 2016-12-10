<?php

namespace Drupal\example;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Defines a service profiler for the Example module.
 */
class ExampleServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $container->register('example.foo', 'Drupal\example\Foo')
      ->addTag('event_subscriber')
      ->addArgument(new Reference('entity_type.manager'));
  }

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $modules = $container->getParameter('container.modules');
    if (isset($modules['dblog'])) {
      // Override default DB logger to exclude some unwanted log messages.
      $container->getDefinition('logger.dblog')
        ->setClass('Drupal\example\Logger\DbLog');
    }
  }

}
