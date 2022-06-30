<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'theme-file',
  description: 'Generates a theme file',
  templatePath: Application::TEMPLATE_PATH . '/theme-file',
  type: GeneratorType::THEME_COMPONENT,
)]
final class ThemeFile extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $assets->addFile('{machine_name}.theme', 'theme.twig');
  }

}
