<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\DrupalGenerator;
use DrupalCodeGenerator\Utils\Validator;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:composer command.
 */
class Composer extends DrupalGenerator {

  protected $name = 'd8:composer';
  protected $description = 'Generates a composer.json file';
  protected $alias = 'composer.json';
  protected $label = 'composer.json';
  protected $nameQuestion = NULL;
  protected $machineNameQuestion = 'Project machine name';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['description'] = $this->ask('Description');

    $type_question = new Question('Type', 'drupal-module');
    $type_question->setValidator([Validator::class, 'validateRequired']);
    $type_question->setAutocompleterValues([
      'drupal-module',
      'drupal-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-drush',
    ]);
    $vars['type'] = $this->io->askQuestion($type_question);

    $vars['drupal_org'] = $this->confirm('Is this project hosted on drupal.org?', FALSE);

    $this->addFile('composer.json', 'd8/composer');
  }

}
