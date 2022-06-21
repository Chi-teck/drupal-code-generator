<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about available Drupal hooks.
 *
 * @todo Create a test for this.
 */
final class HookInfo extends Helper {

  public function __construct(private ModuleHandlerInterface $moduleHandler) {}

  public function getName(): string {
    return 'hook_info';
  }

  /**
   * Gets defined hooks.
   */
  public function getHooks(): array {

    static $hooks;
    if ($hooks) {
      return $hooks;
    }

    $hooks = self::parseHooks(\DRUPAL_ROOT . '/core/core.api.php');

    $api_files = \glob(\DRUPAL_ROOT . '/core/lib/Drupal/Core/*/*.api.php');
    foreach ($api_files as $api_file) {
      if (\file_exists($api_file)) {
        $hooks = \array_merge($hooks, self::parseHooks($api_file));
      }
    }

    foreach ($this->moduleHandler->getModuleList() as $machine_name => $module) {
      $api_file = \DRUPAL_ROOT . '/' . $module->getPath() . '/' . $machine_name . '.api.php';
      if (\file_exists($api_file)) {
        $hooks = \array_merge($hooks, self::parseHooks($api_file));
      }
    }

    return $hooks;
  }

  /**
   * Extracts hooks from PHP file.
   */
  private static function parseHooks(string $file): array {
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

}
