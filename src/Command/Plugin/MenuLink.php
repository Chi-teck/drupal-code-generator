<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:menu-link',
  description: 'Generates menu-link plugin',
  aliases: ['menu-link'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_menu-link',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class MenuLink extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askPluginClass('Class', '{machine_name|camelize}MenuLink');
    $vars['services'] = $ir->askServices(FALSE);
    $assets->addFile('src/Plugin/Menu/{class}.php', 'menu-link.twig');
  }

}
