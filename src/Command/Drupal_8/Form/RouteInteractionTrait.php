<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Trait RouteTrait.
 */
trait RouteInteractionTrait {

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
   * Interacts with the user and builds route variables.
   */
  protected function routeInteraction(InputInterface $input, OutputInterface $output) {

    $vars = &$this->vars;

    $vars['route'] = $this->confirm('Would you like to create a route for this form?');

    $raw_form_id = preg_replace('/_form/', '', Utils::camel2machine($vars['class']));
    $vars['form_id'] = $vars['machine_name'] . '_' . $raw_form_id;

    if ($vars['route']) {
      $this->defaultPathPrefix = $this->defaultPathPrefix ?: '/' . $vars['machine_name'];
      $default_route_path = str_replace('_', '-', $this->defaultPathPrefix . '/' . $raw_form_id);
      $questions['route_name'] = new Question('Route name', '{machine_name}.' . $raw_form_id);
      $questions['route_path'] = new Question('Route path', $default_route_path);
      $questions['route_title'] = new Question('Route title', Utils::machine2human($raw_form_id));
      $questions['route_permission'] = new Question('Route permission', $this->defaultPermission);

      $this->collectVars($questions, $vars);

      $this->addFile('{machine_name}.routing.yml')
        ->template('d8/form/routing.twig')
        ->action('append');
    }

  }

}
