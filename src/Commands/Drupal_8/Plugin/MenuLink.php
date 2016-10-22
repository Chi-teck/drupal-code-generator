<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'class' => ['Class', [$this, 'defaultClass']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $path = $this->createPath('src/Plugin/Menu/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/menu-link.twig', $vars);
  }

  /**
   * Returns default class name for the plugin.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['name']) . 'MenuLink';
  }

}
