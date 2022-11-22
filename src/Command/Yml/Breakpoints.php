<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:breakpoints',
  description: 'Generates a breakpoints yml file',
  aliases: ['breakpoints'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/_breakpoints',
  type: GeneratorType::THEME_COMPONENT,
)]
final class Breakpoints extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $interviewer = $this->createInterviewer($vars);
    $vars['machine_name'] = $interviewer->askMachineName();
    $assets->addFile('{machine_name}.breakpoints.yml', 'breakpoints.twig');
  }

}
