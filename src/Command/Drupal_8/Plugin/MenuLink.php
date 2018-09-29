<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:menu-link command.
 */
class MenuLink extends BaseGenerator {

  protected $name = 'd8:plugin:menu-link';
  protected $description = 'Generates menu-link plugin';
  protected $alias = 'menu-link';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'MenuLink';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/Menu/{class}.php')
      ->template('d8/plugin/menu-link.twig');
  }

}
