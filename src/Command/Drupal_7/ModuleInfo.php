<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:module-info command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd7:module-info';
  protected $description = 'Generates Drupal 7 info file for a module';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'description' => new Question('Module description', 'Module description'),
      'package' => new Question('Package', 'Custom'),
      'version' => new Question('Version', '7.x-1.0-dev'),
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['machine_name'] . '.info', 'd7/module-info.twig', $vars);
  }

}
