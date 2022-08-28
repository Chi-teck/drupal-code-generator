<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

/**
 * Simple form generator.
 *
 * @todo Clean-up.
 */
#[Generator(
  name: 'form:simple',
  description: 'Generates simple form',
  aliases: ['form'],
  templatePath: Application::TEMPLATE_PATH . '/form/simple',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Simple extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['class'] = $ir->ask('Class', 'ExampleForm');
    $vars['raw_form_id'] = \preg_replace('/_form/', '', Utils::camel2machine($vars['class']));
    $vars['form_id'] = '{machine_name}_{raw_form_id}';

    $vars['route'] = $ir->confirm('Would you like to create a route for this form?');
    if ($vars['route']) {
      $default_route_path = \str_replace('_', '-', '/' . $vars['machine_name'] . '/' . $vars['raw_form_id']);
      $vars['route_name'] = $ir->ask('Route name', '{machine_name}.' . $vars['raw_form_id']);
      $vars['route_path'] = $ir->ask('Route path', $default_route_path);
      $vars['route_title'] = $ir->ask('Route title', '{raw_form_id|m2h}');
      $vars['route_permission'] = $ir->ask('Route permission', 'access content');

      $assets->addFile('{machine_name}.routing.yml')
        ->template('routing.twig')
        ->appendIfExists();
    }

    $assets->addFile('src/Form/{class}.php', 'form');
  }

}
