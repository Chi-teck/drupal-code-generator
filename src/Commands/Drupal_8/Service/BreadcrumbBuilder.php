<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:breadcrumb-builder command.
 */
class BreadcrumbBuilder extends BaseGenerator {

  protected $name = 'd8:service:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

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

    $path = $this->createPath('src/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/service/breadcrumb-builder.twig', $vars);

    $this->services[$vars['machine_name'] . '.breadcrumb'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\' . $vars['class'],
      'tags' => [
        [
          'name' => 'breadcrumb_builder',
          'priority' => 1000,
        ],
      ],
    ];

  }

  /**
   * Returns default class name for the breadcrumb builder.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['name'] . 'BreadcrumbBuilder');
  }

}
