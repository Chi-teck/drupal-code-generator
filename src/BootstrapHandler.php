<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Drupal\Core\DrupalKernel;
use DrupalCodeGenerator\ClassResolver\SimpleClassResolver;
use DrupalCodeGenerator\Service\GeneratorFactory;
use Psr\Log\NullLogger;
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
      $root_package = InstalledVersions::getRootPackage();
      \chdir($root_package['install_path']);

      $request = Request::createFromGlobals();
      $kernel = DrupalKernel::createFromRequest($request, $this->classLoader, 'prod');
      $kernel->boot();
      $kernel->preHandle($request);
      $container = $kernel->getContainer();
      self::configureContainer($container);
      return $container;
    }
    catch (\Exception $exception) {
      return NULL;
    }
  }

  private static function configureContainer(ContainerInterface $container): void {
    $generator_factory = new GeneratorFactory(new SimpleClassResolver(), new NullLogger());
    $container->set('dcg.generator_factory', $generator_factory);
  }

}
