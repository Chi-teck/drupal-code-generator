<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:field:type',
  description: 'Generates field type plugin',
  aliases: ['field-type'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/Field/_type',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Type extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass(suffix: 'Item');

    $vars['configurable_storage'] = $ir->confirm('Make the field storage configurable?', FALSE);
    $vars['configurable_instance'] = $ir->confirm('Make the field instance configurable?', FALSE);
    $assets->addFile('src/Plugin/Field/FieldType/{class}.php', 'type.twig');
    $assets->addSchemaFile()->template('schema.twig');
  }

}
