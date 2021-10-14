<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;

/**
 * Implements plugin:ckeditor command.
 */
final class CKEditor extends PluginGenerator {

  protected string $name = 'plugin:ckeditor';
  protected string $description = 'Generates CKEditor plugin';
  protected string $alias = 'ckeditor';
  protected string $label = 'CKEditor';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/ckeditor';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $unprefixed_plugin_id = \preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);

    // Convert plugin ID to hyphen case.
    $vars['short_plugin_id'] = \str_replace('_', '-', $unprefixed_plugin_id);
    $vars['command_name'] = Utils::camelize($unprefixed_plugin_id, FALSE);

    $this->addFile('src/Plugin/CKEditorPlugin/{class}.php', 'ckeditor');
    $this->addFile('js/plugins/{short_plugin_id}/plugin.js', 'plugin');
    $this->addFile('js/plugins/{short_plugin_id}/dialogs/{short_plugin_id}.js', 'dialog');

    $this->addFile('js/plugins/{short_plugin_id}/icons/{short_plugin_id}.png')
      ->content(\file_get_contents(Application::TEMPLATE_PATH . '/plugin/ckeditor/icon.png'))
      ->appendIfExists();
  }

}
