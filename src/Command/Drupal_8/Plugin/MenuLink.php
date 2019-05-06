<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:menu-link command.
 */
class MenuLink extends ModuleGenerator {

  protected $name = 'd8:plugin:menu-link';
  protected $description = 'Generates menu-link plugin';
  protected $alias = 'menu-link';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'MenuLink';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($questions);

    $this->addFile('src/Plugin/Menu/{class}.php')
      ->template('d8/plugin/menu-link.twig');
  }

}
