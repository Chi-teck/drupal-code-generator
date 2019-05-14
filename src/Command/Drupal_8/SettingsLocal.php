<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\Generator;
use DrupalCodeGenerator\Utils\Validator;

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
        'database' => $this->ask('Database name', 'drupal_local', [Validator::class, 'validateRequired']),
        'username' => $this->ask('Database username', 'root', [Validator::class, 'validateRequired']),
        'password' => $this->ask('Database password', NULL, [Validator::class, 'validateRequired']),
        'host' => $this->ask('Database host', 'localhost', [Validator::class, 'validateRequired']),
        'driver' => $this->ask('Database type', 'mysql', [Validator::class, 'validateRequired']),
      ];
    }

    $this->addFile('settings.local.php', 'd8/settings.local');
  }

}
