<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

/**
 * Implements misc:d7:ctools-plugin:relationship command.
 */
final class Relationship extends BasePlugin {

  protected string $name = 'misc:d7:ctools-plugin:relationship';
  protected string $description = 'Generates CTools relationship plugin';
  protected string $template = 'relationship';
  protected string $subDirectory = 'plugins/relationships';

}
