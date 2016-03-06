<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:breadcrumb-builder command.
 */
class BreadcrumbBuilder extends BaseGenerator {

  protected $name = 'd8:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', [$this, 'defaultClass']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = $this->createPath('src/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/breadcrumb-builder.twig', $vars);
  }

  /**
   * Return default class name for the breadcrumb builder.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['name'] . 'BreadcrumbBuilder');
  }

}
