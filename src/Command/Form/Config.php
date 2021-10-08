<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

/**
 * Implements form:config command.
 */
final class Config extends FormGenerator {

  protected $name = 'form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';
  protected $defaultPathPrefix = '/admin/config/system';
  protected $defaultPermission = 'administer site configuration';
  protected $defaultClass = 'SettingsForm';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->generateRoute($vars);

    if ($vars['route']) {
      if ($vars['link'] = $this->confirm('Would you like to create a menu link for this route?')) {

        $vars['link_title'] = $this->ask('Link title', $vars['route_title']);
        $vars['link_description'] = $this->ask('Link description');
        // Try to guess parent menu item using route path.
        if (\preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $vars['link_parent'] = $this->ask('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $this->addFile('{machine_name}.links.menu.yml')
          ->template('links.menu')
          ->appendIfExists();
      }
    }

    $this->addFile('src/Form/{class}.php', 'form');
    $this->addSchemaFile()->template('schema');
  }

}
