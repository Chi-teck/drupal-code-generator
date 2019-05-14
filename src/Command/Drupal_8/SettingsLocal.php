<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\Generator;

/**
 * Implements d8:settings-local command.
 */
class SettingsLocal extends Generator {

  protected $name = 'd8:settings-local';
  protected $description = 'Generates Drupal 8 settings.local.php file';
  protected $alias = 'settings.local.php';
  protected $destination = 'sites/default';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->vars;
    $vars['db_override'] = $this->confirm('Override database configuration?', FALSE);

    if ($vars['db_override']) {
      $vars += [
        'database' => $this->ask('Database name', 'drupal_local', [__CLASS__, 'validateRequired']),
        'username' => $this->ask('Database username', 'root', [__CLASS__, 'validateRequired']),
        'password' => $this->ask('Database password', NULL, [__CLASS__, 'validateRequired']),
        'host' => $this->ask('Database host', 'localhost', [__CLASS__, 'validateRequired']),
        'driver' => $this->ask('Database type', 'mysql', [__CLASS__, 'validateRequired']),
      ];
    }

    $this->addFile('settings.local.php', 'd8/settings.local');
  }

}
