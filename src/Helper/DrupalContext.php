<?php

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Helper\Helper;

/**
 * Drupal context.
 */
class DrupalContext extends Helper {

  /**
   * Drupal container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * List of currently installed modules.
   *
   * @var \Drupal\Core\Extension\Extension[]
   */
  protected $modules = [];

  /**
   * List of currently installed themes.
   *
   * @var \Drupal\Core\Extension\Extension[]
   */
  protected $themes = [];

  /**
   * DrupalContext constructor.
   */
  public function __construct($container) {
    $this->container = $container;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'drupal_context';
  }

  /**
   * Returns a list of currently installed extensions.
   *
   * @param string $extension_type
   *   Extension type (module|theme|profile).
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   An associative array whose keys are the machine names of the themes and
   *   whose values are extension names.
   */
  public function getExtensionList(string $extension_type) :array {
    switch ($extension_type) {
      case 'module':
        if (!$this->modules) {
          /** @var \Drupal\Core\Extension\ModuleHandlerInterface $module_handler */
          $module_handler = $this->container->get('module_handler');
          foreach ($module_handler->getModuleList() as $machine_name => $module) {
            $this->modules[$machine_name] = $module_handler->getName($machine_name);
          }
        }
        return $this->modules;

      case 'theme':
        if (!$this->themes) {
          /** @var \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler */
          $theme_handler = $this->container->get('theme_handler');
          foreach ($theme_handler->listInfo() as $machine_name => $theme) {
            $this->themes[$machine_name] = $theme->info['name'];
          }
        }
        return $this->themes;

      case 'profile':
        // @todo Support profiles.
        return [];
    }
  }

  /**
   * Returns destination for generated code.
   *
   * @param string $extension_type
   *   Extension type.
   * @param bool $is_new
   *   Indicates that generated code is a new Drupal extension.
   * @param string|null $machine_name
   *   Machine mane of the extension.
   *
   * @return string|null
   *   The destination.
   */
  public function getDestination(string $extension_type, bool $is_new, ?string $machine_name) :?string {
    $destination = NULL;

    switch ($extension_type) {
      case 'module':
        $modules_dir = is_dir(DRUPAL_ROOT . '/modules/custom') ?
          'modules/custom' : 'modules';

        if ($is_new) {
          $destination = $modules_dir;
        }
        elseif ($machine_name) {
          $module_handler = $this->container->get('module_handler');
          $destination = isset($this->modules[$machine_name])
            ? $module_handler->getModule($machine_name)->getPath()
            : $modules_dir . '/' . $machine_name;
        }
        break;

      case 'theme':
        $themes_dir = is_dir(DRUPAL_ROOT . '/themes/custom') ?
          'themes/custom' : 'themes';

        if ($is_new) {
          $destination = $themes_dir;
        }
        elseif ($machine_name) {
          $theme_handler = $this->container->get('theme_handler');
          $destination = isset($this->themes[$machine_name])
            ? $theme_handler->getTheme($machine_name)->getPath()
            : $themes_dir . '/' . $machine_name;
        }
        break;

      case 'profile':
        // @todo Support profiles.
        break;

      default:
        throw new \UnexpectedValueException(sprintf('Unsupported extension type "%s".', $extension_type));

    }

    return $destination;

  }

}
