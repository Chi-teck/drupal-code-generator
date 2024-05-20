<?php

declare(strict_types=1);

namespace DrupalCodeGenerator;

use Composer\InstalledVersions;
use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\Event\GeneratorInfo;
use DrupalCodeGenerator\Event\GeneratorInfoAlter;
use DrupalCodeGenerator\Helper\Drupal\ConfigInfo;
use DrupalCodeGenerator\Helper\Drupal\HookInfo;
use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Helper\Drupal\PermissionInfo;
use DrupalCodeGenerator\Helper\Drupal\RouteInfo;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Helper\Drupal\ThemeInfo;
use DrupalCodeGenerator\Helper\Dumper\DryDumper;
use DrupalCodeGenerator\Helper\Dumper\FileSystemDumper;
use DrupalCodeGenerator\Helper\Printer\ListPrinter;
use DrupalCodeGenerator\Helper\Printer\TablePrinter;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer\TwigRenderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem as SymfonyFileSystem;
use Twig\Loader\FilesystemLoader as TemplateLoader;

/**
 * DCG console application.
 *
 * @psalm-suppress DeprecatedInterface
 * @psalm-suppress DeprecatedTrait
 *
 * @todo Use Drupal replacement for ContainerAwareInterface when it's available.
 * @see https://www.drupal.org/project/drupal/issues/3397522
 */
final class Application extends BaseApplication implements EventDispatcherInterface {

  /**
   * Path to DCG root directory.
   */
  public const string ROOT = __DIR__ . '/..';

  /**
   * DCG version.
   *
   * @deprecated Use \DrupalCodeGenerator\Application->getVersion() instead.
   */
  public const string VERSION = 'unknown';

  /**
   * DCG API version.
   */
  public const int API = 3;

  /**
   * Path to templates directory.
   */
  public const string TEMPLATE_PATH = self::ROOT . '/templates';

  /**
   * {@selfdoc}
   */
  private ContainerInterface $container;

  /**
   * Creates the application.
   *
   * @psalm-suppress ArgumentTypeCoercion
   */
  public static function create(ContainerInterface $container): self {
    $application = new self(
      'Drupal Code Generator',
      InstalledVersions::getPrettyVersion('chi-teck/drupal-code-generator'),
    );
    $application->container = $container;

    $file_system = new SymfonyFileSystem();
    $template_loader = new TemplateLoader();
    $template_loader->addPath(self::TEMPLATE_PATH . '/_lib', 'lib');
    $application->setHelperSet(
      new HelperSet([
        new QuestionHelper(),
        new DryDumper($file_system),
        new FileSystemDumper($file_system),
        new TwigRenderer(new TwigEnvironment($template_loader)),
        new ListPrinter(),
        new TablePrinter(),
        new ModuleInfo($container->get('module_handler'), $container->get('extension.list.module')),
        new ThemeInfo($container->get('theme_handler')),
        new ServiceInfo($container),
        new HookInfo($container->get('module_handler')),
        new RouteInfo($container->get('router.route_provider')),
        new ConfigInfo($container->get('config.factory')),
        new PermissionInfo($container->get('user.permissions')),
      ]),
    );

    $generator_factory = new GeneratorFactory(
      $container->get('class_resolver'),
    );

    $core_generators = $generator_factory->getGenerators();
    $user_generators = [];
    $application->dispatch(new GeneratorInfo($user_generators));

    $all_generators = \array_merge($core_generators, $user_generators);
    $application->addCommands(
      $application->dispatch(new GeneratorInfoAlter($all_generators))->generators,
    );

    $application->add(new Navigation());
    $application->setDefaultCommand('navigation');

    /** @var \DrupalCodeGenerator\Application $application */
    $application = $application->dispatch($application);
    return $application;
  }

  /**
   * Returns Drupal container.
   */
  public function getContainer(): ContainerInterface {
    return $this->container;
  }

  /**
   * {@inheritdoc}
   *
   * @template T as object
   * @psalm-param T $event
   * @psalm-return T
   *
   * @todo Remove this once Symfony drops support for event-dispatcher-contracts v2.
   * @see \Symfony\Contracts\EventDispatcher\EventDispatcherInterface::dispatch()
   * @psalm-suppress UnusedPsalmSuppress
   * @psalm-suppress InvalidReturnType
   * @psalm-suppress InvalidReturnStatement
   */
  public function dispatch(object $event): object {
    return $this->container->get('event_dispatcher')->dispatch($event);
  }

}
