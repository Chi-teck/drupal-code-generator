<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Drupal\Core\DrupalKernel;
use DrupalCodeGenerator\Service\GeneratorFactory;
use DrupalCodeGenerator\Service\ModuleInfo;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a handler to bootstrap DCG environment.
 */
class BootstrapHandler {

  public function __construct(private ClassLoader $classLoader) {}

  public function bootstrap(): ContainerInterface {
    self::assertInstallation();
    $container = $this->boostrapDrupal();
    self::configureContainer($container);
    return $container;
  }

  private static function assertInstallation(): void {
    $preflight = \defined('Drupal::VERSION') &&
      \version_compare(\Drupal::VERSION, '10.0.0-dev', '>=') &&
      \class_exists(InstalledVersions::class) &&
      \class_exists(Request::class) &&
      \class_exists(DrupalKernel::class);
    if (!$preflight) {
      throw new \RuntimeException('Could not load Drupal.');
    }
  }

  private function boostrapDrupal(): ContainerInterface {
    $root_package = InstalledVersions::getRootPackage();
    \chdir($root_package['install_path']);
    $request = Request::createFromGlobals();
    $kernel = DrupalKernel::createFromRequest($request, $this->classLoader, 'prod');
    $kernel->boot();
    $kernel->preHandle($request);
    return $kernel->getContainer();
  }

  private static function configureContainer(ContainerInterface $container): void {
    $generator_factory = new GeneratorFactory(
      $container->get('class_resolver'),
      new NullLogger(),
    );
    $container->set('dcg.generator_factory', $generator_factory);
    $container->set('dcg.module_info', new ModuleInfo($container->get('module_handler')));
  }

}
