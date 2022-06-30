<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:links:action',
  description: 'Generates a links.action yml file',
  aliases: ['action-links'],
  templatePath: Application::TEMPLATE_PATH . '/yml/links/action',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Action extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $interviewer = $this->createInterviewer($vars);
    $vars['machine_name'] = $interviewer->askMachineName();
    $assets->addFile('{machine_name}.links.action.yml', 'links.action');
  }

}
