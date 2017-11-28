<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:module command.
 */
class Module extends BaseGenerator {

  protected $name = 'd7:module';
  protected $description = 'Generates Drupal 7 module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['description'] = new Question('Module description', 'Module description.');
    $questions['package'] = new Question('Package', 'Custom');

    $vars = $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('{machine_name}/{machine_name}.info')
      ->template('d7/module-info.twig');

    $this->addFile()
      ->path('{machine_name}/{machine_name}.module')
      ->template('d7/module.twig');

    $this->addFile()
      ->path('{machine_name}/{machine_name}.install')
      ->template('d7/install.twig');

    $this->addFile()
      ->path('{machine_name}/{machine_name}.admin.inc')
      ->template('d7/admin.inc.twig');

    $this->addFile()
      ->path('{machine_name}/{machine_name}.pages.inc')
      ->template('d7/pages.inc.twig');

    $this->addFile()
      ->path('{machine_name}/' . str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d7/javascript.twig');
  }

}
