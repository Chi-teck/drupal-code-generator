<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:form:config command.
 */
class Config extends Base {

  protected $name = 'd8:form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $options['default_class'] = 'SettingsForm';
    $options['default_form_id'] = function ($vars) {
      return $vars['machine_name'] . '_settings';
    };
    $options['default_permission'] = 'administer site configuration';
    $options['template'] = 'd8/form/config.twig';
    $this->doInteract($input, $output, $options);
  }

}
