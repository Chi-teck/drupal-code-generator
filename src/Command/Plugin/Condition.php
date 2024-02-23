<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:condition',
  description: 'Generates condition plugin',
  aliases: ['condition'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_condition',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Condition extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();
    $vars['services'] = $ir->askServices(FALSE);
    $assets->addFile('src/Plugin/Condition/{class}.php', 'condition.twig');
    $assets->addSchemaFile()->template('schema.twig');
  }

}
