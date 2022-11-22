<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:links:action',
  description: 'Generates a links.action yml file',
  aliases: ['action-links'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/Links/_action',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Action extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $vars['machine_name'] = $this->createInterviewer($vars)->askMachineName();
    $assets->addFile('{machine_name}.links.action.yml', 'links.action.twig');
  }

}
