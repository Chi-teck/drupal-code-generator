<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'template',
  description: 'Generates a template',
  aliases: ['template'],
  templatePath: Application::TEMPLATE_PATH . '/template',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Template extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['template_name'] = $ir->ask('Template name', 'example');
    $vars['create_theme'] = $ir->confirm('Create theme hook?');
    $vars['create_preprocess'] = $ir->confirm('Create preprocess hook?');

    $assets->addFile('templates/{template_name}.html.twig', 'template');

    if ($vars['create_theme'] || $vars['create_preprocess']) {
      $assets->addFile('{machine_name}.module')
        ->template('module')
        ->appendIfExists(7);
    }
  }

}
