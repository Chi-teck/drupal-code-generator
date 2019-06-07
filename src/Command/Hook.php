<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset;
use Symfony\Component\Console\Question\Question;

/**
 * Implements hook command.
 */
final class Hook extends ModuleGenerator {

  protected $name = 'hook';
  protected $description = 'Generates a hook';
  protected $templatePath = Application::TEMPLATE_PATH;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $hook_question = new Question('Hook name');
    $hook_question->setValidator(function ($value) {
      if (!in_array($value, $this->supportedHooks())) {
        throw new \UnexpectedValueException('The value is not correct class name.');
      }
      return $value;
    });
    $hook_question->setAutocompleterValues($this->supportedHooks());

    $vars['hook_name'] = $this->io->askQuestion($hook_question);

    // Most Drupal hooks are situated in a module file but some are not.
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

    $vars['file_type'] = 'module';
    foreach ($special_hooks as $group => $hooks) {
      if (in_array($vars['hook_name'], $hooks)) {
        $vars['file_type'] = $group;
        break;
      }
    }

    $this->addFile()
      ->path('{machine_name}.{file_type}')
      ->headerTemplate('_lib/file-docs/{file_type}')
      ->template('hook/{hook_name}')
      ->action(Asset::APPEND)
      ->headerSize(7);
  }

  /**
   * Returns list of supported hooks.
   */
  protected function supportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir($this->templatePath . '/hook'), ['.', '..']));
  }

}
