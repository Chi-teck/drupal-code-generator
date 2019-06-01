<?php

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:settings-local command.
 */
class SettingsLocal extends Generator {

  protected $name = 'misc:settings-local';
  protected $description = 'Generates Drupal 8 settings.local.php file';
  protected $alias = 'settings.local.php';
  protected $label = 'settings.local.php';

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

    $this->addFile('settings.local.php', 'misc/settings.local');
  }

}
