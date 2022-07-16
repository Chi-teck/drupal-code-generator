<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;
use DrupalCodeGenerator\Validator\RequiredMachineName;

#[Generator(
  name: 'yml:theme-info',
  description: 'Generates a theme info yml file',
  aliases: ['theme-info'],
  templatePath: Application::TEMPLATE_PATH . '/yml/theme-info',
  type: GeneratorType::THEME_COMPONENT,
  label: 'Info (theme)',
)]
final class ThemeInfo extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['base_theme'] = $ir->ask('Base theme', 'classy', new RequiredMachineName());
    $vars['description'] = $ir->ask('Description', 'A flexible theme with a responsive, mobile-first layout.', new Required());
    $vars['package'] = $ir->ask('Package', 'Custom');
    $assets->addFile('{machine_name}.info.yml', 'theme-info');
  }

}
