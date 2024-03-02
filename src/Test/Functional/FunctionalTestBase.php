<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Test\Functional;

use Composer\InstalledVersions;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\BootstrapHandler;
use DrupalCodeGenerator\Helper\Renderer\TwigRenderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader as FileSystemLoader;

/**
 * Base class for functional tests.
 */
abstract class FunctionalTestBase extends TestCase {

  protected string $directory;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  protected function tearDown(): void {
    parent::tearDown();
    (new Filesystem())->remove($this->directory);
  }

  /**
   * Creates DCG application.
   */
  final protected static function createApplication(?ContainerInterface $container = NULL): Application {
    if (!$container) {
      $container = self::bootstrap();
    }

    $application = Application::create($container);
    $application->setAutoExit(FALSE);

    $helper_set = $application->getHelperSet();

    // Replace default question helper to ease parsing output.
    $helper_set->set(new QuestionHelper());

    // Replace default renderer to enable 'strict_variables' in tests.
    $template_loader = new FileSystemLoader();
    $template_loader->addPath(Application::TEMPLATE_PATH . '/_lib', 'lib');
    $twig_environment = new TwigEnvironment($template_loader, ['strict_variables' => TRUE]);
    $helper_set->set(new TwigRenderer($twig_environment));
    return $application;
  }

  /**
   * Bootstraps Drupal.
   */
  final protected static function bootstrap(): ContainerInterface {
    $root_package = InstalledVersions::getRootPackage();
    /** @psalm-suppress UnresolvableInclude */
    $class_loader = require $root_package['install_path'] . 'vendor/autoload.php';
    $bootstrap_handler = new BootstrapHandler($class_loader);
    return $bootstrap_handler->bootstrap();
  }

}
