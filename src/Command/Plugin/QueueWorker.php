<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:queue-worker',
  description: 'Generates queue worker plugin',
  aliases: ['queue-worker'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_queue-worker',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class QueueWorker extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();

    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Plugin/QueueWorker/{class}.php', 'queue-worker.twig');
  }

}
