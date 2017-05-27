<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implements d8:yml:task-links command.
 */
class TaskLinks extends BaseGenerator {

  protected $name = 'd8:yml:task-links';
  protected $description = 'Generates a links.task yml file';
  protected $alias = 'task-links';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'machine_name' => ['Module machine name'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.links.task.yml'] = $this->render('d8/yml/links.task.yml.twig', $vars);
  }

}
