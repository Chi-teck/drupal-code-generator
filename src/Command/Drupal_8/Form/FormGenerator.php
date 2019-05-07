<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Base class for form generators.
 */
abstract class FormGenerator extends ModuleGenerator {

  /**
   * Default form class.
   *
   * @var string
   */
  protected $defaultClass;

  /**
   * Default path prefix.
   *
   * @var string
   */
  protected $defaultPathPrefix;

  /**
   * Default permission.
   *
   * @var string
   */
  protected $defaultPermission;

  /**
   * {@inheritdoc}
   */
  protected function &collectDefault(): array {
    $vars = &parent::collectDefault();
    $vars['class'] = $this->ask('Class', $this->defaultClass);
    $vars['raw_form_id'] = preg_replace('/_form/', '', Utils::camel2machine($vars['class']));
    $vars['form_id'] = $vars['machine_name'] . '_' . $vars['raw_form_id'];
    return $vars;
  }

  /**
   * Interacts with the user and builds route variables.
   */
  protected function generateRoute() {
    $vars = &$this->vars;

    $vars['route'] = $this->confirm('Would you like to create a route for this form?');
    if ($vars['route']) {
      $this->defaultPathPrefix = $this->defaultPathPrefix ?: '/' . $vars['machine_name'];
      $default_route_path = str_replace('_', '-', $this->defaultPathPrefix . '/' . $vars['raw_form_id']);
      $vars['route_name'] = $this->ask('Route name', '{machine_name}.' . $vars['raw_form_id']);
      $vars['route_path'] = $this->ask('Route path', $default_route_path);
      $vars['route_title'] = $this->ask('Route title', Utils::machine2human($vars['raw_form_id']));
      $vars['route_permission'] = $this->ask('Route permission', $this->defaultPermission);

      $this->addFile('{machine_name}.routing.yml')
        ->template('d8/form/routing')
        ->action('append');
    }

  }

}
