<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\ModuleHandlerInterface;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about installed Drupal modules.
 *
 * @todo Test this.
 */
final class ModuleInfo extends Helper {

  public function __construct(private ModuleHandlerInterface $moduleHandler) {}

  public function getName(): string {
    return 'module_info';
  }

  /**
   * Returns a list of currently installed modules.
   */
  public function getModules(): array {
    $modules = [];
    foreach ($this->moduleHandler->getModuleList() as $machine_name => $module) {
      $modules[$machine_name] = $this->moduleHandler->getName($machine_name);
    }
    return $modules;
  }

  /**
   * Returns destination for generated module code.
   */
  public function getDestination(bool $is_new, string $machine_name): ?string {
    $destination = NULL;

    $modules_dir = \is_dir(\DRUPAL_ROOT . '/modules/custom') ?
      'modules/custom' : 'modules';

    if ($is_new) {
      $destination = $modules_dir;
    }
    elseif ($machine_name) {
      $destination = \array_key_exists($machine_name, $this->getModules())
        ? $this->moduleHandler->getModule($machine_name)->getPath()
        : $modules_dir . '/' . $machine_name;
    }

    if ($destination) {
      $destination = \DRUPAL_ROOT . '/' . $destination;
    }
    return $destination;
  }

  /**
   * Returns module human name.
   */
  public function getModuleName(string $machine_name): ?string {
    // @todo Use title case of the machine name as fallback.
    return $this->getModules()[$machine_name] ?? Utils::machine2human($machine_name);
  }

}
