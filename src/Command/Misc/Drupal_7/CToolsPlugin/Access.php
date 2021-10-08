<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

/**
 * Implements misc:d7:ctools-plugin:access command.
 */
final class Access extends BasePlugin {

  protected string $name = 'misc:d7:ctools-plugin:access';
  protected string $description = 'Generates CTools access plugin';
  protected string $template = 'access';
  protected string $subDirectory = 'plugins/access';

}
