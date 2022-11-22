<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:views:argument-default',
  description: 'Generates views default argument plugin',
  aliases: ['views-argument-default'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/Views/_argument-default',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ArgumentDefault extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();

    $vars['configurable'] = $ir->confirm('Make the plugin configurable?', FALSE);

    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Plugin/views/argument_default/{class}.php')
      ->template('argument-default.twig');

    if ($vars['configurable']) {
      $assets->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('argument-default-schema.twig');
    }
  }

}
