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

    $vars = &$this->vars;

    if ($vars['route']) {
      $link_question = new ConfirmationQuestion('Would you like to create a menu link for this route?', TRUE);
      $vars['link'] = $this->ask($input, $output, $link_question);
      if ($vars['link']) {

        $questions['link_title'] = new Question('Link title', $vars['route_title']);
        $questions['link_description'] = new Question('Link description');
        // Try to guess parent menu item using route path.
        if (preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $questions['link_parent'] = new Question('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $this->collectVars($input, $output, $questions);
        $this->addFile()
          ->path('{machine_name}.links.menu.yml')
          ->template('d8/form/links.menu.twig')
          ->action('append');
      }
    }

  }

}
