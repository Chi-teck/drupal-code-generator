<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
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
  protected function generate() :void {
    $vars = &$this->vars;
    $db_driver_question = new Question('Database driver', 'mysql');
    $db_driver_question->setAutocompleterValues(['mysql', 'pgsql', 'sqlite']);
    $vars['db_driver'] = $this->io->askQuestion($db_driver_question);
    $vars['db_name'] = $this->ask('Database name', 'drupal');
    $vars['db_user'] = $this->ask('Database user', 'root');
    $vars['db_password'] = $this->ask('Database password', '123');

    // @see: drupal_get_hash_salt()
    $vars['hash_salt'] = hash('sha256', serialize($vars));

    $this->addFile('settings.php', 'd7/settings');
  }

}
