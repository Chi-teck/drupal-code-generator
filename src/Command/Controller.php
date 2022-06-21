<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'controller',
  description: 'Generates a controller',
  templatePath: Application::TEMPLATE_PATH . '/controller',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Controller extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->askClass(default_value: '{machine_name|camelize}Controller');

    $vars['services'] = $ir->askServices(FALSE);

    if ($ir->confirm('Would you like to create a route for this controller?')) {
      $vars['route_name'] = $ir->ask('Route name', '{machine_name}.example');
      $vars['route_path'] = $ir->ask('Route path', '/{machine_name|u2h}/example');
      $vars['route_title'] = $ir->ask('Route title', 'Example');
      $vars['route_permission'] = $ir->ask('Route permission', 'access content');
      $assets->addFile('{machine_name}.routing.yml', 'route.twig')->appendIfExists();
    }

    $assets->addFile('src/Controller/{class}.php', 'controller.twig');
  }

}
