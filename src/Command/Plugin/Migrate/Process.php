<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:migrate:process',
  description: 'Generates migrate process plugin',
  aliases: ['migrate-process'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/Migrate/_process',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Process extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_id'] = $ir->askPluginId(default: NULL);
    $vars['class'] = $ir->askPluginClass();
    $vars['services'] = $ir->askServices(FALSE);
    $assets->addFile('src/Plugin/migrate/process/{class}.php', 'process.twig');
  }

}
