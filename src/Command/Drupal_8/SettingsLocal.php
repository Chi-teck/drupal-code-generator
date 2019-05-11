<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;

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
  protected function generate() :void {
    $vars = &$this->vars;
    $vars['db_override'] = $this->confirm('Override database configuration?', FALSE);

    if ($vars['db_override']) {
      $vars += [
        'database' => $this->ask('Database name', 'drupal_local', [Utils::class, 'validateRequired']),
        'username' => $this->ask('Database username', 'root', [Utils::class, 'validateRequired']),
        'password' => $this->ask('Database password', NULL, [Utils::class, 'validateRequired']),
        'host' => $this->ask('Database host', 'localhost', [Utils::class, 'validateRequired']),
        'driver' => $this->ask('Database type', 'mysql', [Utils::class, 'validateRequired']),
      ];
    }

    $this->addFile('settings.local.php', 'd8/settings.local.twig');
  }

}
