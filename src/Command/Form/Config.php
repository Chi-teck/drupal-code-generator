<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;

/**
 * Implements form:config command.
 */
final class Config extends FormGenerator {

  protected string $name = 'form:config';
  protected string $description = 'Generates a configuration form';
  protected string $alias = 'config-form';
  protected string $templatePath = Application::TEMPLATE_PATH . '/form/config';
  protected ?string $defaultPathPrefix = '/admin/config/system';
  protected string $defaultPermission = 'administer site configuration';
  protected string $defaultClass = 'SettingsForm';

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
