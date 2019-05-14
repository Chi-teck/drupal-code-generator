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
        'database' => $this->ask('Database name', 'drupal_local', '::validateRequired'),
        'username' => $this->ask('Database username', 'root', '::validateRequired'),
        'password' => $this->ask('Database password', NULL, '::validateRequired'),
        'host' => $this->ask('Database host', 'localhost', '::validateRequired'),
        'driver' => $this->ask('Database type', 'mysql', '::validateRequired'),
      ];
    }

    $this->addFile('settings.local.php', 'd8/settings.local');
  }

}
