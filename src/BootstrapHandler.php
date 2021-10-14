<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\Autoload\ClassLoader;
use Drupal\Core\DrupalKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a handler to bootstrap Drupal.
 */
class BootstrapHandler {

  /**
   * The class loader.
   */
  private ClassLoader $classLoader;

  /**
   * Construct a BootstrapHandler object.
   */
  public function __construct(ClassLoader $class_loader) {
    $this->classLoader = $class_loader;
  }

  /**
   * Bootstraps Drupal.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerInterface|null
   *   Current service container or null if bootstrap failed.
   */
  public function bootstrap(): ?ContainerInterface {
    if (!\defined('Drupal::VERSION') || \version_compare(\Drupal::VERSION, '9.0.0', '<')) {
      return NULL;
    }
    try {
      $request = Request::createFromGlobals();
      $kernel = DrupalKernel::createFromRequest($request, $this->classLoader, 'prod');
      $kernel->boot();
      $kernel->preHandle($request);
      return $kernel->getContainer();
    }
    catch (\Exception $exception) {
      return NULL;
    }
  }

}
