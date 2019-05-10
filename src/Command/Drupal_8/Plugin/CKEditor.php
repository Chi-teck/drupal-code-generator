<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Utils;

/**
 * Implements d8:plugin:ckeditor command.
 */
class CKEditor extends PluginGenerator {

  protected $name = 'd8:plugin:ckeditor';
  protected $description = 'Generates CKEditor plugin';
  protected $alias = 'ckeditor';
  protected $label = 'CKEditor';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $unprefixed_plugin_id = preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);

    // Convert plugin ID to hyphen case.
    $vars['short_plugin_id'] = str_replace('_', '-', $unprefixed_plugin_id);
    $vars['command_name'] = Utils::camelize($unprefixed_plugin_id, FALSE);

    $this->addFile('src/Plugin/CKEditorPlugin/{class}.php')
      ->template('d8/plugin/_ckeditor/ckeditor');

    $this->addFile('js/plugins/{short_plugin_id}/plugin.js')
      ->template('d8/plugin/_ckeditor/plugin');

    $this->addFile('js/plugins/{short_plugin_id}/dialogs/{short_plugin_id}.js')
      ->template('d8/plugin/_ckeditor/dialog');

    $this->addFile('js/plugins/{short_plugin_id}/icons/{short_plugin_id}.png')
      ->content(file_get_contents($this->templatePath . '/d8/plugin/_ckeditor/icon.png'))
      ->action('replace');
  }

}
