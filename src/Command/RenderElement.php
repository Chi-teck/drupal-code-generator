<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'render-element',
  description: 'Generates Drupal render element',
  templatePath: Application::TEMPLATE_PATH . '/render-element',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class RenderElement extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $assets->addFile('src/Element/Entity.php', 'render-element.twig');
  }

}
