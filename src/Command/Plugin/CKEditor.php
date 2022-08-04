<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

#[Generator(
  name: 'plugin:ckeditor',
  description: 'Generates CKEditor plugin',
  aliases: ['ckeditor'],
  templatePath: Application::TEMPLATE_PATH . '/plugin/ckeditor',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'CKEditor',
)]
final class CKEditor extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();

    $unprefixed_plugin_id = Utils::removePrefix($vars['plugin_id'], $vars['machine_name'] . '_');

    // Convert plugin ID to hyphen case.
    $vars['short_plugin_id'] = \str_replace('_', '-', $unprefixed_plugin_id);
    $vars['command_name'] = Utils::camelize($unprefixed_plugin_id, FALSE);

    $assets->addFile('src/Plugin/CKEditorPlugin/{class}.php', 'ckeditor');
    $assets->addFile('js/plugins/{short_plugin_id}/plugin.js', 'plugin');
    $assets->addFile('js/plugins/{short_plugin_id}/dialogs/{short_plugin_id}.js', 'dialog');

    $assets->addFile('js/plugins/{short_plugin_id}/icons/{short_plugin_id}.png')
      ->content(\file_get_contents(Application::TEMPLATE_PATH . '/plugin/ckeditor/icon.png'))
      ->appendIfExists();
  }

}
