<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:block',
  description: 'Generates block plugin',
  aliases: ['block'],
  templatePath: Application::TEMPLATE_PATH . '/plugin/block',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Block extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();

    $vars['plugin_label'] = $ir->askPluginLabel('Block admin label');
    $vars['plugin_id'] = $ir->askPluginId();

    $vars['class'] = $ir->askPluginClass(suffix: 'Block');
    $vars['category'] = $ir->ask('Block category', 'Custom');
    $vars['configurable'] = $ir->confirm('Make the block configurable?', FALSE);

    $vars['services'] = $ir->askServices(FALSE);

    $vars['access'] = $ir->confirm('Create access callback?', FALSE);

    $assets->addFile('src/Plugin/Block/{class}.php', 'block');

    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema');
    }
  }

}
