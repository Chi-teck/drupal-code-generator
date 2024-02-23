<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:views:field',
  description: 'Generates views field plugin',
  aliases: ['views-field'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/Views/_field',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Field extends BaseGenerator {

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

    $assets->addFile('src/Plugin/views/field/{class}.php', 'field.twig');

    if ($vars['configurable']) {
      $assets->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('schema.twig');
    }
  }

}
