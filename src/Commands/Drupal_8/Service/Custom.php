<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:service:custom command.
 */
class Custom extends BaseGenerator {

  protected $name = 'd8:service:custom';
  protected $description = 'Generates a custom Drupal service';
  protected $alias = 'service';
  protected $inline = 2;

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'service_name' => ['Service name', [$this, 'defaultServiceName']],
      'class' => ['Class', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = $this->createPath('src/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/service/custom.twig', $vars);

    $this->services[$vars['service_name']] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\' . $vars['class'],
      'arguments' => ['@entity.query', '@entity_type.manager'],
    ];
  }

  /**
   * Returns default service name.
   */
  protected function defaultServiceName($vars) {
    return $vars['machine_name'] . '.example';
  }

}
