<?php

namespace DrupalCodeGenerator\Command;

use Symfony\Component\Console\Question\Question;

/**
 * Implements composer command.
 */
final class Composer extends DrupalGenerator {

  protected $name = 'composer';
  protected $description = 'Generates a composer.json file';
  protected $alias = 'composer.json';
  protected $label = 'composer.json';
  protected $nameQuestion = NULL;
  protected $machineNameQuestion = 'Project machine name';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['description'] = $this->ask('Description');

    $type_question = new Question('Type', 'drupal-module');
    $type_question->setValidator([self::class, 'validateRequired']);
    $type_question->setAutocompleterValues([
      'drupal-module',
      'drupal-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-drush',
    ]);
    $vars['type'] = $this->io->askQuestion($type_question);

    $vars['drupal_org'] = $this->confirm('Is this project hosted on drupal.org?', FALSE);

    $this->addFile('composer.json', 'composer');
  }

}
