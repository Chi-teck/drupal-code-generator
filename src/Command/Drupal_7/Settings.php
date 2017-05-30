<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:settings.php command.
 */
class Settings extends BaseGenerator {

  protected $name = 'd7:settings.php';
  protected $description = 'Generates Drupal 7 settings.php file';
  protected $destination = 'sites/default';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'db_driver' => ['Database driver', 'mysql'],
      'db_name' => ['Database name', 'drupal'],
      'db_user' => ['Database user', 'root'],
      'db_password' => ['Database password', '123'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    // @see: drupal_get_hash_salt()
    $vars['hash_salt'] = hash('sha256', serialize($vars));
    $this->files['settings.php'] = $this->render('d7/settings.twig', $vars);
  }

}
