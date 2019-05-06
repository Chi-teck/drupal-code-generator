<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\ModuleGenerator;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:form:config command.
 */
class Config extends ModuleGenerator {

  use RouteInteractionTrait;

  protected $name = 'd8:form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $questions['class'] = new Question('Class', 'SettingsForm');

    $this->collectVars($questions);

    $this->defaultPathPrefix = '/admin/config/system';
    $this->defaultPermission = 'administer site configuration';
    $this->routeInteraction();

    $vars = &$this->vars;

    if ($vars['route']) {
      if ($vars['link'] = $this->confirm('Would you like to create a menu link for this route?')) {

        $questions['link_title'] = new Question('Link title', $vars['route_title']);
        $questions['link_description'] = new Question('Link description');
        // Try to guess parent menu item using route path.
        if (preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $questions['link_parent'] = new Question('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $this->collectVars($questions);
        $this->addFile('{machine_name}.links.menu.yml')
          ->template('d8/form/links.menu.twig')
          ->action('append');
      }
    }

    $this->addFile('src/Form/{class}.php')
      ->template('d8/form/config.twig');

  }

}
