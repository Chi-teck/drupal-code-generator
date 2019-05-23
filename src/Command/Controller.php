<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements controller command.
 */
class Controller extends ModuleGenerator {

  protected $name = 'controller';
  protected $description = 'Generates a controller';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Controller');

    $this->collectServices(FALSE);

    if ($this->confirm('Would you like to create a route for this controller?')) {
      $vars['route_name'] = $this->ask('Route name', '{machine_name}.example');
      $vars['route_path'] = $this->ask('Route path', '/{machine_name|u2h}/example');
      $vars['route_title'] = $this->ask('Route title', 'Example');
      $vars['route_permission'] = $this->ask('Route permission', 'access content');
      $this->addFile('{machine_name}.routing.yml', 'controller-route')
        ->action('append');
    }

    $this->addFile('src/Controller/{class}.php', 'controller');
  }

}
