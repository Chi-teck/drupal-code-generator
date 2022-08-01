<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:route-subscriber',
  description: 'Generates a route subscriber',
  aliases: ['route-subscriber'],
  templatePath: Application::TEMPLATE_PATH . '/service/route-subscriber',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class RouteSubscriber extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->ask('Class', '{machine_name|camelize}RouteSubscriber');
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/EventSubscriber/{class}.php', 'route-subscriber');
    $assets->addServicesFile()->template('services');
  }

}
