<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:composer command.
 */
class Composer extends BaseGenerator {

  protected $name = 'd8:composer';
  protected $description = 'Generates a composer.json file';
  protected $alias = 'composer.json';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = [
      'Project machine name',
    ];
    $questions['description'] = new Question('Description');
    $questions['type'] = new Question('Type', 'drupal-module');
    $questions['type']->setAutocompleterValues([
      'drupal-module',
      'drupal-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-drush',
    ]);

    $questions['drupal_org'] = [
      'Is this project hosted on drupal.org?',
      'no',
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files['composer.json'] = $this->render('d8/composer.twig', $vars);
  }

}
