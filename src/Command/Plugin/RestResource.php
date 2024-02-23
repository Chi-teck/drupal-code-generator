<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:rest-resource',
  description: 'Generates rest resource plugin',
  aliases: ['rest-resource'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_rest-resource',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'REST resource',
)]
final class RestResource extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();

    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass(suffix: 'Resource');

    $assets->addFile('src/Plugin/rest/resource/{class}.php', 'rest-resource.twig');
  }

}
