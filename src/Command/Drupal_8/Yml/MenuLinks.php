<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:menu-links command.
 */
class MenuLinks extends BaseGenerator {

  protected $name = 'd8:yml:menu-links';
  protected $description = 'Generates a links.menu yml file';
  protected $alias = 'menu-links';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'machine_name' => ['Module machine name'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.links.menu.yml'] = $this->render('d8/yml/links.menu.yml.twig', $vars);
  }

}
