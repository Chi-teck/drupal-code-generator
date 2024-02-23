<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:field:formatter',
  description: 'Generates field formatter plugin',
  aliases: ['field-formatter'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/Field/_formatter',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Formatter extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass(suffix: 'Formatter');

    $vars['configurable'] = $ir->confirm('Make the formatter configurable?', FALSE);
    $assets->addFile('src/Plugin/Field/FieldFormatter/{class}.php', 'formatter.twig');
    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema.twig');
    }
  }

}
