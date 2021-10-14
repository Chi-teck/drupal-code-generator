<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Generator;
use Symfony\Component\Console\Question\Question;

/**
 * Implements misc:d7:settings.php command.
 */
final class Settings extends Generator {

  protected string $name = 'misc:d7:settings.php';
  protected string $description = 'Generates Drupal 7 settings.php file';
  protected string $label = 'settings.php';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/settings.php';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $db_driver_question = new Question('Database driver', 'mysql');
    $db_driver_question->setAutocompleterValues(['mysql', 'pgsql', 'sqlite']);
    $vars['db_driver'] = $this->io->askQuestion($db_driver_question);
    $vars['db_name'] = $this->ask('Database name', 'drupal');
    $vars['db_user'] = $this->ask('Database user', 'root');
    $vars['db_password'] = $this->ask('Database password', '123');

    // @see: drupal_get_hash_salt()
    $vars['hash_salt'] = \hash('sha256', \serialize($vars));

    $this->addFile('settings.php', 'settings');
  }

}
