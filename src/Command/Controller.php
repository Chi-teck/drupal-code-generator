<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

#[Generator(
  name: 'controller',
  description: 'Generates a controller',
  templatePath: Application::TEMPLATE_PATH . '/_controller',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Controller extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Controller');

    $vars['services'] = $ir->askServices(FALSE);

    if ($ir->confirm('Would you like to create a route for this controller?')) {
      $unprefixed_class = Utils::camel2machine(Utils::removeSuffix($vars['class'], 'Controller'));
      // Route name like 'foo.foo' would look weird.
      if ($unprefixed_class === $vars['machine_name']) {
        $unprefixed_class = 'example';
      }
      $vars['route_name'] = $ir->ask('Route name', '{machine_name}.' . $unprefixed_class);
      $vars['unprefixed_route_name'] = \str_replace(
        '.', '_', Utils::removePrefix($vars['route_name'], $vars['machine_name'] . '.'),
      );
      $vars['route_path'] = $ir->ask('Route path', '/{machine_name|u2h}/{unprefixed_route_name|u2h}');
      $vars['route_title'] = $ir->ask('Route title', '{unprefixed_route_name|m2t}');
      $vars['route_permission'] = $ir->askPermission('Route permission', 'access content');
      $assets->addFile('{machine_name}.routing.yml', 'route.twig')->appendIfExists();
    }

    $assets->addFile('src/Controller/{class}.php', 'controller.twig');
  }

}
