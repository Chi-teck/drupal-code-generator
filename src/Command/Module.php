<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'module',
  description: 'Generates Drupal module',
  templatePath: Application::TEMPLATE_PATH . '/module',
  type: GeneratorType::MODULE,
)]
final class Module extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['name'] = $ir->askName();
    $vars['machine_name'] = $ir->askMachineName();

    $vars['description'] = $ir->ask('Module description', 'Provides additional functionality for the site.', new Required());
    $vars['package'] = $ir->ask('Package', 'Custom');

    $dependencies = $ir->ask('Dependencies (comma separated)');
    $vars['dependencies'] = $dependencies ?
      \array_map('trim', \explode(',', \strtolower($dependencies))) : [];

    $vars['class_prefix'] = '{machine_name|camelize}';

    $assets->addFile('{machine_name}/{machine_name}.info.yml', 'model.info.yml');

    if ($ir->confirm('Would you like to create module file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.module', 'model.module');
    }

    if ($ir->confirm('Would you like to create install file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.install', 'model.install');
    }

    if ($ir->confirm('Would you like to create libraries.yml file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.libraries.yml', 'model.libraries.yml');
    }

    if ($ir->confirm('Would you like to create permissions.yml file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.permissions.yml', 'model.permissions.yml');
    }

    if ($ir->confirm('Would you like to create event subscriber?', FALSE)) {
      $assets->addFile("{machine_name}/src/EventSubscriber/{class_prefix}Subscriber.php")
        ->template('src/EventSubscriber/ExampleSubscriber.php');
      $assets->addFile('{machine_name}/{machine_name}.services.yml', 'model.services.yml');
    }

    if ($ir->confirm('Would you like to create block plugin?', FALSE)) {
      $assets->addFile('{machine_name}/src/Plugin/Block/ExampleBlock.php')
        ->template('src/Plugin/Block/ExampleBlock.php');
    }

    if ($vars['controller'] = $ir->confirm('Would you like to create a controller?', FALSE)) {
      $assets->addFile("{machine_name}/src/Controller/{class_prefix}Controller.php")
        ->template('src/Controller/ExampleController.php');
    }

    if ($vars['form'] = $ir->confirm('Would you like to create settings form?', FALSE)) {
      $assets->addFile('{machine_name}/src/Form/SettingsForm.php')
        ->template('src/Form/SettingsForm.php');
      $assets->addFile('{machine_name}/config/schema/{machine_name}.schema.yml')
        ->template('config/schema/model.schema.yml');
      $assets->addFile('{machine_name}/{machine_name}.links.menu.yml')
        ->template('model.links.menu');
    }

    if ($vars['controller'] || $vars['form']) {
      $assets->addFile('{machine_name}/{machine_name}.routing.yml')
        ->template('model.routing.yml');
    }

  }

}
