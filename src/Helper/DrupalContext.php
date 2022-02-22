<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Command\DrupalGenerator;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A helper that provides a bridge between generators and Drupal installation.
 *
 * @todo Support installation profiles.
 */
class DrupalContext extends Helper {

  /**
   * Drupal container.
   */
  protected ContainerInterface $container;

  /**
   * List of currently installed modules.
   *
   * @var \Drupal\Core\Extension\Extension[]
   */
  protected array $modules = [];

  /**
   * List of currently installed themes.
   *
   * @var \Drupal\Core\Extension\Extension[]
   */
  protected array $themes = [];

  /**
   * Defines the root directory of the Drupal installation.
   */
  protected string $drupalRoot;

  /**
   * DrupalContext constructor.
   */
  public function __construct(ContainerInterface $container, string $drupal_root = \DRUPAL_ROOT) {
    $this->container = $container;
    $this->drupalRoot = $drupal_root;
  }

  /**
   * Return Drupal container.
   */
  public function getContainer(): ContainerInterface {
    return $this->container;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'drupal_context';
  }

  /**
   * Returns a list of currently installed modules.
   */
  public function getModules(): array {
    if (!$this->modules) {
      /** @var \Drupal\Core\Extension\ModuleHandlerInterface $module_handler */
      $module_handler = $this->container->get('module_handler');
      foreach ($module_handler->getModuleList() as $machine_name => $module) {
        $this->modules[$machine_name] = $module_handler->getName($machine_name);
      }
    }
    return $this->modules;
  }

  /**
   * Returns destination for generated module code.
   */
  public function getModuleDestination(bool $is_new, ?string $machine_name): ?string {
    $destination = NULL;

    $modules_dir = \is_dir($this->getDrupalRoot() . '/modules/custom') ?
      'modules/custom' : 'modules';

    if ($is_new) {
      $destination = $modules_dir;
    }
    elseif ($machine_name) {
      $destination = \array_key_exists($machine_name, $this->getModules())
        ? $this->container->get('module_handler')->getModule($machine_name)->getPath()
        : $modules_dir . '/' . $machine_name;
    }

    if ($destination) {
      $destination = $this->getDrupalRoot() . '/' . $destination;
    }

    return $destination;
  }

  /**
   * Returns destination for generated module code.
   */
  public function getThemeDestination(bool $is_new, ?string $machine_name): ?string {
    $destination = NULL;

    $themes_dir = \is_dir($this->drupalRoot . '/themes/custom') ?
      'themes/custom' : 'themes';

    if ($is_new) {
      $destination = $themes_dir;
    }
    elseif ($machine_name) {
      $destination = \array_key_exists($machine_name, $this->getThemes())
        ? $this->container->get('theme_handler')->getTheme($machine_name)->getPath()
        : $themes_dir . '/' . $machine_name;
    }

    if ($destination) {
      $destination = $this->getDrupalRoot() . '/' . $destination;
    }

    return $destination;
  }

  /**
   * Returns a list of currently installed modules.
   */
  public function getThemes(): array {
    if (!$this->themes) {
      /** @var \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler */
      $theme_handler = $this->container->get('theme_handler');
      foreach ($theme_handler->listInfo() as $machine_name => $theme) {
        $this->themes[$machine_name] = $theme->info['name'];
      }
    }
    return $this->themes;
  }

  /**
   * Returns a list of currently installed extensions.
   *
   * @deprecated Use ::getModules() or getThemes() instead.
   */
  public function getExtensionList(int $extension_type): array {
    switch ($extension_type) {
      case DrupalGenerator::EXTENSION_TYPE_MODULE:
        return $this->getModules();

      case DrupalGenerator::EXTENSION_TYPE_THEME:
        return $this->getThemes();

      default:
        throw new \UnexpectedValueException(\sprintf('Unsupported extension type "%s".', $extension_type));
    }
  }

  /**
   * Returns destination for generated code.
   *
   * @deprecated Use ::getModuleDestination() or getThemeDestination() instead.
   */
  public function getDestination(int $extension_type, bool $is_new, ?string $machine_name): ?string {
    switch ($extension_type) {
      case DrupalGenerator::EXTENSION_TYPE_MODULE:
        return $this->getModuleDestination($is_new, $machine_name);

      case DrupalGenerator::EXTENSION_TYPE_THEME:
        return $this->getThemeDestination($is_new, $machine_name);

      default:
        throw new \UnexpectedValueException(\sprintf('Unsupported extension type "%s".', $extension_type));
    }
    return $destination;
  }

  /**
   * Gets defined hooks.
   *
   * @return array
   *   An associative array of hook templates keyed by hook name.
   */
  public function getHooks(): array {

    static $hooks;
    if ($hooks) {
      return $hooks;
    }

    $hooks = self::parseHooks($this->getDrupalRoot() . '/core/core.api.php');

    $api_files = \glob($this->getDrupalRoot() . '/core/lib/Drupal/Core/*/*.api.php');
    foreach ($api_files as $api_file) {
      if (\file_exists($api_file)) {
        $hooks = \array_merge($hooks, self::parseHooks($api_file));
      }
    }

    $module_handler = $this->container->get('module_handler');
    foreach ($module_handler->getModuleList() as $machine_name => $module) {
      $api_file = $this->getDrupalRoot() . '/' . $module->getPath() . '/' . $machine_name . '.api.php';
      if (\file_exists($api_file)) {
        $hooks = \array_merge($hooks, self::parseHooks($api_file));
      }
    }

    return $hooks;
  }

  /**
   * Returns the root directory of the Drupal installation.
   */
  public function getDrupalRoot(): string {
    return $this->drupalRoot;
  }

  /**
   * Extracts hooks from PHP file.
   *
   * @param string $file
   *   File to parse.
   *
   * @return array
   *   Array of parsed hooks keyed by hook name.
   */
  protected static function parseHooks(string $file): array {
    $code = \file_get_contents($file);
    \preg_match_all("/function hook_(.*)\(.*\n\}\n/Us", $code, $matches);

    $results = [];
    foreach ($matches[0] as $index => $hook) {
      $hook_name = $matches[1][$index];
      $output = "/**\n * Implements hook_$hook_name().\n */\n";
      $output .= \str_replace('function hook_', 'function {{ machine_name }}_', $hook);
      $results[$hook_name] = $output;
    }

    return $results;
  }

  /**
   * Gets all defined service IDs.
   *
   * @return array
   *   An array of all defined service IDs.
   */
  public function getServicesIds(): array {
    return $this->container->getServiceIds();
  }

  /**
   * Gets all defined services.
   *
   * @return array
   *   Compiled service definition.
   */
  public function getServiceDefinition(string $service_id): ?array {
    $services = $this->container
      ->get('kernel')
      ->getCachedContainerDefinition();
    // @phpcs:disable DrupalPractice.FunctionCalls.InsecureUnserialize.InsecureUnserialize
    return isset($services['services'][$service_id]) ?
      \unserialize($services['services'][$service_id]) : NULL;
  }

}
