<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

/**
 * A generator for a simple form.
 */
#[Generator(
  name: 'form:simple',
  description: 'Generates simple form',
  aliases: ['form'],
  templatePath: Application::TEMPLATE_PATH . '/Form/_simple',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Simple extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['class'] = $ir->askClass(default: 'ExampleForm');
    $vars['raw_form_id'] = Utils::camel2machine(Utils::removeSuffix($vars['class'], 'Form'));
    $vars['form_id'] = '{machine_name}_{raw_form_id}';

    $vars['route'] = $ir->confirm('Would you like to create a route for this form?');
    if ($vars['route']) {
      $vars['route_name'] = $ir->ask('Route name', '{machine_name}.' . $vars['raw_form_id']);
      $default_route_path = \str_replace('_', '-', '/' . $vars['machine_name'] . '/' . $vars['raw_form_id']);
      $vars['route_path'] = $ir->ask('Route path', $default_route_path);
      $vars['route_title'] = $ir->ask('Route title', '{raw_form_id|m2t}');
      $vars['route_permission'] = $ir->askPermission('Route permission', 'access content');
      $assets->addFile('{machine_name}.routing.yml')
        ->template('routing.twig')
        ->appendIfExists();
    }

    $assets->addFile('src/Form/{class}.php', 'form.twig');
  }

}
