<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:settings.php command.
 */
class Settings extends BaseGenerator {

  protected $name = 'd7:settings.php';
  protected $description = 'Generates Drupal 7 settings.php file';
  protected $destination = 'sites/default';
  protected $label = 'settings.php';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['db_driver'] = new Question('Database driver', 'mysql');
    $questions['db_driver']->setAutocompleterValues(['mysql', 'pgsql', 'sqlite']);
    $questions['db_name'] = new Question('Database name', 'drupal');
    $questions['db_user'] = new Question('Database user', 'root');
    $questions['db_password'] = new Question('Database password', '123');

    $vars = $this->collectVars($input, $output, $questions);
    // @see: drupal_get_hash_salt()
    $vars['hash_salt'] = hash('sha256', serialize($vars));
    $this->setFile('settings.php', 'd7/settings.twig', $vars);
  }

}
