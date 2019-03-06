<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
    $options = [
      'default_class' => 'SettingsForm',
      'default_permission' => 'administer site configuration',
      'default_path_prefix' => '/admin/config/system',
      'template' => 'd8/form/config.twig',
    ];
    $this->doInteract($input, $output, $options);

    if ($this->vars['route']) {
      $link_question = new ConfirmationQuestion('Would you like to create a menu link for this route?', TRUE);
      $this->vars['link'] = $this->ask($input, $output, $link_question);
      if ($this->vars['link']) {
        // Try to guess parent menu item using route path.
        if (preg_match('#^/admin/config/([^/]+)/[^/]+$#', $this->vars['route_path'], $matches)) {
          $link_parent_question = new Question('Parent menu item', 'system.admin_config_' . $matches[1]);
          $this->vars['link_parent'] = $this->ask($input, $output, $link_parent_question);
        }
        $this->addFile()
          ->path('{machine_name}.links.menu.yml')
          ->template('d8/form/links.menu.twig')
          ->action('append');
      }
    }

  }

}
