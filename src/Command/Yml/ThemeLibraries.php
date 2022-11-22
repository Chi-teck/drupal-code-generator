<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:theme-libraries',
  description: 'Generates theme libraries yml file',
  aliases: ['theme-libraries'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/_theme-libraries',
  type: GeneratorType::THEME_COMPONENT,
  label: 'Libraries (theme)',
)]
final class ThemeLibraries extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $vars['machine_name'] = $this->createInterviewer($vars)->askMachineName();
    $assets->addFile('{machine_name}.libraries.yml', 'theme-libraries.twig');
  }

}
