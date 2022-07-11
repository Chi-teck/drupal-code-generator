<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:field:widget',
  description: 'Generates field widget plugin',
  aliases: ['field-widget'],
  templatePath: Application::TEMPLATE_PATH . '/plugin/field/widget',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Widget extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass(suffix: 'Widget');

    $vars['configurable'] = $ir->confirm('Make the widget configurable?', FALSE);
    $assets->addFile('src/Plugin/Field/FieldWidget/{class}.php', 'widget');
    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema');
    }
  }

}
