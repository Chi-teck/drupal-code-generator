<?php

declare(strict_types=1);

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
  aliases: ['ckeditor', 'ckeditor-plugin'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_ckeditor',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'CKEditor',
)]
final class CKEditor extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();

    $vars['unprefixed_plugin_id'] = Utils::removePrefix($vars['plugin_id'], $vars['machine_name'] . '_');
    $vars['class'] = Utils::camelize($vars['unprefixed_plugin_id']);

    // Convert plugin ID to hyphen case.
    $vars['fe_plugin_id'] = Utils::camelize($vars['unprefixed_plugin_id'], FALSE);

    $assets->addFile('webpack.config.js', 'webpack.config.js');
    $assets->addFile('package.json', 'package.json.twig');
    $assets->addFile('.gitignore', 'gitignore');
    $assets->addFile('{machine_name}.libraries.yml', 'model.libraries.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.ckeditor5.yml', 'model.ckeditor5.yml.twig')
      ->appendIfExists();

    $assets->addFile('css/{unprefixed_plugin_id|u2h}.admin.css', 'css/model.admin.css.twig');
    $assets->addFile('icons/{unprefixed_plugin_id|u2h}.svg', 'icons/example.svg');
    $assets->addFile('js/ckeditor5_plugins/{fe_plugin_id}/src/{class}.js', 'js/ckeditor5_plugins/example/src/Example.js.twig');
    $assets->addFile('js/ckeditor5_plugins/{fe_plugin_id}/src/index.js', 'js/ckeditor5_plugins/example/src/index.js.twig');
    $assets->addDirectory('js/build');
  }

}
