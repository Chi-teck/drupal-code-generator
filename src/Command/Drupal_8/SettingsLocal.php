<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorQuestion;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = [
      'db_override' => ['Override database configuration?', 'yes'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['db_override']) {
      $questions = [
        'database' => ['Database name', 'drupal_8'],
        'username' => ['Database username', 'root'],
        'password' => ['Database password', ''],
        'host' => ['Database host', 'localhost'],
        'driver' => ['Database type', 'mysql'],
      ];
      $vars += $this->collectVars($input, $output, $questions);
    }

    $this->files['settings.local.php'] = $this->render('d8/settings.local.twig', $vars);
  }

}
