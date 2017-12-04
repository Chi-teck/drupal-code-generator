<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:settings-local command.
 */
class SettingsLocal extends BaseGenerator {

  protected $name = 'd8:settings-local';
  protected $description = 'Generates Drupal 8 settings.local.php file';
  protected $alias = 'settings.local.php';
  protected $destination = 'sites/default';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['db_override'] = new ConfirmationQuestion('Override database configuration?', FALSE);

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['db_override']) {
      $questions = [
        'database' => new Question('Database name', 'drupal_local'),
        'username' => new Question('Database username', 'root'),
        'password' => new Question('Database password'),
        'host' => new Question('Database host', 'localhost'),
        'driver' => new Question('Database type', 'mysql'),
      ];
      array_walk($questions, function (Question $question) {
        $question->setValidator([Utils::class, 'validateRequired']);
      });
      $this->collectVars($input, $output, $questions);
    }

    $this->addFile()
      ->path('settings.local.php')
      ->template('d8/settings.local.twig');
  }

}
