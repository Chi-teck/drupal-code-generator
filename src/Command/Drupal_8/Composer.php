<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:composer command.
 */
class Composer extends BaseGenerator {

  protected $name = 'd8:composer';
  protected $description = 'Generates a composer.json file';
  protected $alias = 'composer.json';
  protected $label = 'composer.json';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = new Question('Project machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $questions['description'] = new Question('Description');
    $questions['type'] = new Question('Type', 'drupal-module');
    $questions['type']->setValidator([Utils::class, 'validateRequired']);
    $questions['type']->setAutocompleterValues([
      'drupal-module',
      'drupal-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-drush',
    ]);
    $questions['drupal_org'] = new ConfirmationQuestion('Is this project hosted on drupal.org?', FALSE);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('composer.json')
      ->template('d8/composer.twig');
  }

}
