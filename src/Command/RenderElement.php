<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredMachineName;

#[Generator(
  name: 'render-element',
  description: 'Generates Drupal render element',
  templatePath: Application::TEMPLATE_PATH . '/_render-element',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class RenderElement extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['type'] = $ir->ask('Element ID (#type)', validator: new RequiredMachineName());
    $vars['class'] = $ir->askClass(default: '{type|camelize}');
    $assets->addFile('src/Element/{class}.php', 'render-element.twig');
  }

}
