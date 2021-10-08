<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Base class for form generators.
 */
abstract class FormGenerator extends ModuleGenerator {

  /**
   * Default form class.
   */
  protected string $defaultClass;

  /**
   * Default path prefix.
   */
  protected ?string $defaultPathPrefix = NULL;

  /**
   * Default permission.
   */
  protected string $defaultPermission;

  /**
   * {@inheritdoc}
   */
  protected function collectDefault(array &$vars): void {
    parent::collectDefault($vars);
    $vars['class'] = $this->ask('Class', $this->defaultClass);
    $vars['raw_form_id'] = \preg_replace('/_form/', '', Utils::camel2machine($vars['class']));
    $vars['form_id'] = '{machine_name}_{raw_form_id}';
  }

  /**
   * Interacts with the user and builds route variables.
   */
  protected function generateRoute(array &$vars): void {
    $vars['route'] = $this->confirm('Would you like to create a route for this form?');
    if ($vars['route']) {
      $this->defaultPathPrefix = $this->defaultPathPrefix ?: '/' . $vars['machine_name'];
      $default_route_path = \str_replace('_', '-', $this->defaultPathPrefix . '/' . $vars['raw_form_id']);
      $vars['route_name'] = $this->ask('Route name', '{machine_name}.' . $vars['raw_form_id']);
      $vars['route_path'] = $this->ask('Route path', $default_route_path);
      $vars['route_title'] = $this->ask('Route title', '{raw_form_id|m2h}');
      $vars['route_permission'] = $this->ask('Route permission', $this->defaultPermission);

      $this->addFile('{machine_name}.routing.yml')
        ->template('form/routing')
        ->appendIfExists();
    }
  }

}
