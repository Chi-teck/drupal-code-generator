<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:views:style',
  description: 'Generates views style plugin',
  aliases: ['views-style'],
  templatePath: Application::TEMPLATE_PATH . '/plugin/views/style',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Style extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();

    $vars['configurable'] = $ir->confirm('Make the plugin configurable?');

    $assets->addFile('src/Plugin/views/style/{class}.php')
      ->template('style');

    $assets->addFile('templates/views-style-{plugin_id|u2h}.html.twig')
      ->template('template');

    $assets->addFile('{machine_name}.module')
      ->template('preprocess')
      ->appendIfExists(7);

    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema');
    }

  }

}
