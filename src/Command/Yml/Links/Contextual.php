<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:links:contextual',
  description: 'Generates links.contextual yml file',
  aliases: ['contextual-links'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/Links/_contextual',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Contextual extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $vars['machine_name'] = $this->createInterviewer($vars)->askMachineName();
    $assets->addFile('{machine_name}.links.contextual.yml', 'links.contextual.twig');
  }

}
