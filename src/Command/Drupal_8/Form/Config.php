<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

/**
 * Implements d8:form:config command.
 */
class Config extends FormGenerator {

  protected $name = 'd8:form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';
  protected $defaultPathPrefix = '/admin/config/system';
  protected $defaultPermission = 'administer site configuration';
  protected $defaultClass = 'SettingsForm';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $this->generateRoute();

    if ($vars['route']) {
      if ($vars['link'] = $this->confirm('Would you like to create a menu link for this route?')) {

        $vars['link_title'] = $this->ask('Link title', $vars['route_title']);
        $vars['link_description'] = $this->ask('Link description');
        // Try to guess parent menu item using route path.
        if (preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $vars['link_parent'] = $this->ask('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $this->addFile('{machine_name}.links.menu.yml')
          ->template('d8/form/links.menu')
          ->action('append');
      }
    }

    $this->addFile('src/Form/{class}.php', 'd8/form/config');
    $this->addSchemaFile()->template('d8/form/config-schema');
  }

}
