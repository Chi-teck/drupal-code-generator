<?php

declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Drupal\Core\DrupalKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a handler to bootstrap Drupal.
 */
final class BootstrapHandler {

  /**
   * Constructs the object.
   */
  public function __construct(private readonly ClassLoader $classLoader) {}

  /**
   * Bootstraps Drupal.
   */
  public function bootstrap(): ContainerInterface {
    self::assertInstallation();

    $root_package = InstalledVersions::getRootPackage();
    \chdir($root_package['install_path']);
    $request = Request::createFromGlobals();
    $kernel = DrupalKernel::createFromRequest($request, $this->classLoader, 'prod');
    $kernel->boot();
    $kernel->preHandle($request);
    // Cancel Drupal error handler to get all errors in STDOUT.
    \restore_error_handler();
    \error_reporting(\E_ALL);
    return $kernel->getContainer();
  }

  /**
   * Asserts Drupal instance.
   *
   * @throws \RuntimeException
   */
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
