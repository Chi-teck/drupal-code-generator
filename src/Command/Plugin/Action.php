<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:action',
  description: 'Generates action plugin',
  aliases: ['action'],
  templatePath: Application::TEMPLATE_PATH . '/plugin/action',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Action extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel('Action label', 'Update node title');
    $vars['plugin_id'] = $ir->askPluginId();
    // @todo Change default value.
    $vars['class'] = $ir->askPluginClass(default_value: 'Foo');

    $vars['category'] = $ir->ask('Action category', 'Custom');
    $vars['configurable'] = $ir->confirm('Make the action configurable?', FALSE);

    $assets->addFile('src/Plugin/Action/{class}.php', 'action.twig');

    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema');
    }
  }

}
