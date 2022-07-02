<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about available Drupal hooks.
 *
 * @todo Clean-up.
 * @todo Create a test for this.
 */
final class HookInfo extends Helper {

  /**
   * Constructs helper.
   */
  public function __construct(private ModuleHandlerInterface $moduleHandler) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'hook_info';
  }

  /**
   * Gets templates for all available hooks.
   */
  public function getHookTemplates(): array {

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
   *
   * @todo Test this.
   */
  private static function parseHooks(string $file): array {
    $code = \file_get_contents($file);
    \preg_match_all("/function hook_(.*)\(.*\n\}\n/Us", $code, $matches);

    $results = [];
    foreach ($matches[0] as $index => $hook) {
      $hook_name = $matches[1][$index];
      $output = self::getHeaderTemplate(self::getFileType($hook_name));
      $output .= "/**\n * Implements hook_$hook_name().\n */\n";
      $output .= \str_replace('function hook_', 'function {{ machine_name }}_', $hook);
      $results[$hook_name] = $output;
    }

    return $results;
  }

  public static function getHeaderTemplate(string $file_type): string {
    $description = match($file_type) {
      'install' => 'Install, update and uninstall functions for the {{ name }} module.',
      'module' => 'Primary module hooks for {{ name }} module.',
      'post_update.php' => 'Post update functions for the {{ name }} module.',
      'tokens.inc' => 'Builds tokens for the {{ name }} module.',
      'views.inc' => 'Views hooks for the {{ name }} module.',
      'views_execution.inc' => 'Provide views runtime hooks for the {{ name }} module.',
      default => throw new \InvalidArgumentException('Unsupported file type.'),
    };
    return <<< TWIG
      <?php
      
      /**
       * @file
       * $description
       */


      TWIG;
  }

  /**
   * Returns file type of the hook.
   */
  public static function getFileType(string $hook_name): string {

    // Drupal hooks that are not situated in MODULE_NAME.module file.
    $special_hooks = [
      'install' => [
        'install',
        'uninstall',
        'schema',
        'requirements',
        'update_N',
        'update_last_removed',
      ],
      // See views_hook_info().
      'views.inc' => [
        'views_data',
        'views_data_alter',
        'views_analyze',
        'views_invalidate_cache',
        'field_views_data',
        'field_views_data_alter',
        // See \Drupal\views\views::$plugins.
        'views_plugins_access_alter',
        'views_plugins_area_alter',
        'views_plugins_argument_alter',
        'views_plugins_argument_default_alter',
        'views_plugins_argument_validator_alter',
        'views_plugins_cache_alter',
        'views_plugins_display_extender_alter',
        'views_plugins_display_alter',
        'views_plugins_exposed_form_alter',
        'views_plugins_field_alter',
        'views_plugins_filter_alter',
        'views_plugins_join_alter',
        'views_plugins_pager_alter',
        'views_plugins_query_alter',
        'views_plugins_relationship_alter',
        'views_plugins_row_alter',
        'views_plugins_sort_alter',
        'views_plugins_style_alter',
        'views_plugins_wizard_alter',
      ],
      'views_execution.inc' => [
        'views_query_substitutions',
        'views_form_substitutions',
        'views_pre_view',
        'views_pre_build',
        'views_post_build',
        'views_pre_execute',
        'views_post_execute',
        'views_pre_render',
        'views_post_render',
        'views_query_alter',
      ],
      // See system_hook_info().
      'tokens.inc' => [
        'token_info',
        'token_info_alter',
        'tokens',
        'tokens_alter',
      ],
      'post_update.php' => [
        'post_update_N',
      ],
    ];

    foreach ($special_hooks as $group => $hooks) {
      if (\in_array($hook_name, $hooks)) {
        return $group;
      }
    }

    return 'module';
  }

}
