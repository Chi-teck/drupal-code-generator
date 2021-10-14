<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements module command.
 */
final class Module extends ModuleGenerator {

  protected string $name = 'module';
  protected string $description = 'Generates Drupal module';
  protected bool $isNewExtension = TRUE;
  protected string $templatePath = Application::TEMPLATE_PATH . '/module';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['description'] = $this->ask('Module description', 'Provides additional functionality for the site.', '::validateRequired');
    $vars['package'] = $this->ask('Package', 'Custom');

    $dependencies = $this->ask('Dependencies (comma separated)');
    $vars['dependencies'] = $dependencies ?
      \array_map('trim', \explode(',', \strtolower($dependencies))) : [];

    $vars['class_prefix'] = '{machine_name|camelize}';

    $this->addFile('{machine_name}/{machine_name}.info.yml', 'model.info.yml');

    if ($this->confirm('Would you like to create module file?', FALSE)) {
      $this->addFile('{machine_name}/{machine_name}.module', 'model.module');
    }

    if ($this->confirm('Would you like to create install file?', FALSE)) {
      $this->addFile('{machine_name}/{machine_name}.install', 'model.install');
    }

    if ($this->confirm('Would you like to create libraries.yml file?', FALSE)) {
      $this->addFile('{machine_name}/{machine_name}.libraries.yml', 'model.libraries.yml');
    }

    if ($this->confirm('Would you like to create permissions.yml file?', FALSE)) {
      $this->addFile('{machine_name}/{machine_name}.permissions.yml', 'model.permissions.yml');
    }

    if ($this->confirm('Would you like to create event subscriber?', FALSE)) {
      $this->addFile("{machine_name}/src/EventSubscriber/{class_prefix}Subscriber.php")
        ->template('src/EventSubscriber/ExampleSubscriber.php');
      $this->addFile('{machine_name}/{machine_name}.services.yml', 'model.services.yml');
    }

    if ($this->confirm('Would you like to create block plugin?', FALSE)) {
      $this->addFile('{machine_name}/src/Plugin/Block/ExampleBlock.php')
        ->template('src/Plugin/Block/ExampleBlock.php');
    }

    if ($vars['controller'] = $this->confirm('Would you like to create a controller?', FALSE)) {
      $this->addFile("{machine_name}/src/Controller/{class_prefix}Controller.php")
        ->template('src/Controller/ExampleController.php');
    }

    if ($vars['form'] = $this->confirm('Would you like to create settings form?', FALSE)) {
      $this->addFile('{machine_name}/src/Form/SettingsForm.php')
        ->template('src/Form/SettingsForm.php');
      $this->addFile('{machine_name}/config/schema/{machine_name}.schema.yml')
        ->template('config/schema/model.schema.yml');
      $this->addFile('{machine_name}/{machine_name}.links.menu.yml')
        ->template('model.links.menu');
    }

    if ($vars['controller'] || $vars['form']) {
      $this->addFile('{machine_name}/{machine_name}.routing.yml')
        ->template('model.routing.yml');
    }

  }

}
