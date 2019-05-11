<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:module:standard command.
 */
class Standard extends ModuleGenerator {

  protected $name = 'd8:module:standard';
  protected $description = 'Generates standard Drupal 8 module';
  protected $alias = 'module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Module description');
    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['dependencies'] = $this->ask('Dependencies (comma separated)');

    $vars['dependencies'] = $vars['dependencies'] ?
      array_map('trim', explode(',', strtolower($vars['dependencies']))) : [];

    $vars['class_prefix'] = Utils::camelize($vars['name']);

    $template_path = 'd8/module/standard/';

    $this->addFile('{machine_name}/{machine_name}.info.yml', $template_path . 'model.info.yml');

    if ($this->confirm('Would you like to create module file?')) {
      $this->addFile('{machine_name}/{machine_name}.module', $template_path . 'model.module');
    }

    if ($this->confirm('Would you like to create install file?')) {
      $this->addFile('{machine_name}/{machine_name}.install', $template_path . 'model.install');
    }

    if ($this->confirm('Would you like to create libraries.yml file?')) {
      $this->addFile('{machine_name}/{machine_name}.libraries.yml', $template_path . 'model.libraries.yml');
    }

    if ($this->confirm('Would you like to create permissions.yml file?')) {
      $this->addFile('{machine_name}/{machine_name}.permissions.yml', $template_path . 'model.permissions.yml');
    }

    if ($this->confirm('Would you like to create event subscriber?')) {
      $this->addFile("{machine_name}/src/EventSubscriber/{class_prefix}Subscriber.php")
        ->template($template_path . 'src/EventSubscriber/ExampleSubscriber.php');
      $this->addFile('{machine_name}/{machine_name}.services.yml', $template_path . 'model.services.yml');
    }

    if ($this->confirm('Would you like to create block plugin?')) {
      $this->addFile('{machine_name}/src/Plugin/Block/ExampleBlock.php')
        ->template($template_path . 'src/Plugin/Block/ExampleBlock.php');
    }

    if ($vars['controller'] = $this->confirm('Would you like to create a controller?')) {
      $this->addFile("{machine_name}/src/Controller/{class_prefix}Controller.php")
        ->template($template_path . 'src/Controller/ExampleController.php');
    }

    if ($vars['form']  = $this->confirm('Would you like to create settings form?')) {
      $this->addFile('{machine_name}/src/Form/SettingsForm.php')
        ->template($template_path . 'src/Form/SettingsForm.php');
      $this->addFile('{machine_name}/config/schema/{machine_name}.schema.yml')
        ->template($template_path . 'config/schema/model.schema.yml');
      $this->addFile('{machine_name}/{machine_name}.links.menu.yml')
        ->template($template_path . 'model.links.menu');
    }

    if ($vars['controller'] || $vars['form']) {
      $this->addFile('{machine_name}/{machine_name}.routing.yml')
        ->template($template_path . 'model.routing.yml');
    }

  }

}
