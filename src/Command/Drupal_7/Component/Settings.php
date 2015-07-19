<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implementation of generate:d7:component:settings.php command.
 */
class Settings extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:d7:component:settings.php';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate Drupal 7 settings.php file';

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
