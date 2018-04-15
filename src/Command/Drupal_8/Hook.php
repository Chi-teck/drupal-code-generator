<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:hook command.
 */
class Hook extends BaseGenerator {

  protected $name = 'd8:hook';
  protected $description = 'Generates a hook';
  protected $alias = 'hook';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['hook_name'] = new Question('Hook name');
    $questions['hook_name']->setValidator(function ($value) {
      if (!in_array($value, $this->supportedHooks())) {
        throw new \UnexpectedValueException('The value is not correct class name.');
      }
      return $value;
    });
    $questions['hook_name']->setAutocompleterValues($this->supportedHooks());

    $vars = $this->collectVars($input, $output, $questions);

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

    $file_type = 'module';
    foreach ($special_hooks as $group => $hooks) {
      if (in_array($vars['hook_name'], $hooks)) {
        $file_type = $group;
        break;
      }
    }

    $this->addFile()
      ->path('{machine_name}.' . $file_type)
      ->headerTemplate("d8/file-docs/$file_type.twig")
      ->template('d8/hook/' . $vars['hook_name'] . '.twig')
      ->action('append')
      ->headerSize(7);
  }

  /**
   * Returns list of supported hooks.
   */
  protected function supportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir($this->templatePath . '/d8/hook'), ['.', '..']));
  }

}
