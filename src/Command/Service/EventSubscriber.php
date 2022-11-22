<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:event-subscriber',
  description: 'Generates an event subscriber',
  aliases: ['event-subscriber'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_event-subscriber',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class EventSubscriber extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Subscriber');
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/EventSubscriber/{class}.php', 'event-subscriber.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
