<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:access-checker command.
 */
class AccessChecker extends BaseGenerator {

  protected $name = 'd8:service:access-checker';
  protected $description = 'Generates an access checker service';
  protected $alias = 'access-checker';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'applies_to' => ['Applies to', 'foo'],
      'class' => ['Class', [$this, 'defaultClass']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = $this->createPath('src/Access/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/service/access-checker.twig', $vars);

    $this->services[$vars['machine_name'] . '.' . $vars['applies_to'] . '_access_checker'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\Access\\' . $vars['class'],
      'tags' => [
        [
          'name' => 'access_check',
          'applies_to' => '_' . $vars['applies_to'],
        ],
      ],
    ];

  }

  /**
   * Returns default class name for the access checker.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['applies_to'] . 'AccessChecker');
  }

}
