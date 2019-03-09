<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:form:config command.
 */
class Config extends BaseGenerator {

  use RouteInteractionTrait;

  protected $name = 'd8:form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'SettingsForm');

    $this->collectVars($input, $output, $questions);

    $this->defaultPathPrefix = '/admin/config/system';
    $this->defaultPermission = 'administer site configuration';
    $this->routeInteraction($input, $output);

    $vars = &$this->vars;

    if ($vars['route']) {
      $link_question = new ConfirmationQuestion('Would you like to create a menu link for this route?', TRUE);
      $vars['link'] = $this->ask($input, $output, $link_question);
      if ($vars['link']) {

        $link_questions['link_title'] = new Question('Link title', $vars['route_title']);
        $link_questions['link_description'] = new Question('Link description');
        // Try to guess parent menu item using route path.
        if (preg_match('#^/admin/config/([^/]+)/[^/]+$#', $vars['route_path'], $matches)) {
          $link_questions['link_parent'] = new Question('Parent menu item', 'system.admin_config_' . $matches[1]);
        }

        $this->collectVars($input, $output, $link_questions);
        $this->addFile()
          ->path('{machine_name}.links.menu.yml')
          ->template('d8/form/links.menu.twig')
          ->action('append');
      }
    }

    $this->addFile()
      ->path('src/Form/{class}.php')
      ->template('d8/form/config.twig');

  }

}
