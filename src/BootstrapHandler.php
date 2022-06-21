<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Drupal\Core\DrupalKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a handler to bootstrap DCG environment.
 */
class BootstrapHandler {

  public function __construct(private ClassLoader $classLoader) {}

  public function bootstrap(): ContainerInterface {
    self::assertInstallation();

    $root_package = InstalledVersions::getRootPackage();
    \chdir($root_package['install_path']);
    $request = Request::createFromGlobals();
    $kernel = DrupalKernel::createFromRequest($request, $this->classLoader, 'prod');
    $kernel->boot();
    $kernel->preHandle($request);
    // Cancel Drupal error handler and send the errors to STDOUT immeditatly.
    \restore_error_handler();
    \error_reporting(\E_ALL);
    return $kernel->getContainer();
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

}
