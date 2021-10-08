<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use Symfony\Component\Console\Question\Question;

/**
 * Implements hook command.
 */
final class Hook extends ModuleGenerator {

  protected string $name = 'hook';
  protected string $description = 'Generates a hook';
  protected string $templatePath = Application::TEMPLATE_PATH;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $hook_question = new Question('Hook name');
    $supported_hooks = $this->getSupportedHooks();
    $hook_validator = static function ($value) use ($supported_hooks) {
      if (!\in_array($value, $supported_hooks)) {
        throw new \UnexpectedValueException('The value is not correct hook name.');
      }
      return $value;
    };
    $hook_question->setValidator($hook_validator);
    $hook_question->setAutocompleterValues($supported_hooks);

    $vars['hook_name'] = $this->io->askQuestion($hook_question);
    $vars['file_type'] = self::getFileType($vars['hook_name']);

    $file = $this->addFile('{machine_name}.{file_type}')
      ->headerTemplate('_lib/file-docs/{file_type}')
      ->appendIfExists()
      ->headerSize(7);

    /** @var \DrupalCodeGenerator\Helper\DrupalContext $drupal_context */
    if ($this->drupalContext) {
      $hook_template = $this->drupalContext->getHooks()[$vars['hook_name']];
      $file->inlineTemplate($hook_template);
    }
    else {
      $file->template('hook/{hook_name}');
    }
  }

  /**
   * Returns list of supported hooks.
   */
  private function getSupportedHooks(): array {
    $hook_names = [];
    if ($this->drupalContext) {
      $hook_names = \array_keys($this->drupalContext->getHooks());
    }
    // When Drupal context is not provided build list of supported hooks from
    // hook template names.
    else {
      $iterator = new \DirectoryIterator($this->templatePath . '/hook');
      foreach ($iterator as $file_info) {
        if (!$file_info->isDot()) {
          $hook_names[] = $file_info->getBasename('.twig');
        }
      }
    }
    return $hook_names;
  }

  /**
   * Returns file type of the hook.
   */
  private static function getFileType(string $hook_name): string {

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
