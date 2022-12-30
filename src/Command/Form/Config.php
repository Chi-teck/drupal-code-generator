<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

/**
 * Config form generator.
 *
 * @todo Clean-up.
 */
#[Generator(
  name: 'form:config',
  description: 'Generates a configuration form',
  aliases: ['config-form'],
  templatePath: Application::TEMPLATE_PATH . '/Form/_config',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Config extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {

    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['class'] = $ir->askClass(default: 'SettingsForm');
    $vars['raw_form_id'] = \preg_replace('/_form/', '', Utils::camel2machine($vars['class']));
    $vars['form_id'] = '{machine_name}_{raw_form_id}';

    $vars['route'] = $ir->confirm('Would you like to create a route for this form?');
    if ($vars['route']) {
      $default_route_path = \str_replace('_', '-', '/admin/config/system/' . $vars['raw_form_id']);
      $vars['route_name'] = $ir->ask('Route name', '{machine_name}.' . $vars['raw_form_id']);
      $vars['route_path'] = $ir->ask('Route path', $default_route_path);
      $vars['route_title'] = $ir->ask('Route title', '{raw_form_id|m2h}');
      $vars['route_permission'] = $ir->askPermission('Route permission', 'administer site configuration');

      $assets->addFile('{machine_name}.routing.yml')
        ->template('routing.twig')
        ->appendIfExists();

      if ($vars['link'] = $ir->confirm('Would you like to create a menu link for this route?')) {

        $vars['link_title'] = $ir->ask('Link title', $vars['route_title']);
        $vars['link_description'] = $ir->ask('Link description');
        // Try to guess parent menu item using route path.
        if (\preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $vars['link_parent'] = $ir->ask('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $assets->addFile('{machine_name}.links.menu.yml')
          ->template('links.menu.twig')
          ->appendIfExists();
      }
    }

    $assets->addFile('src/Form/{class}.php', 'form.twig');
    $assets->addSchemaFile()->template('schema.twig');
  }

}
