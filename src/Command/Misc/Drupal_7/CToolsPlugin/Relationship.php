<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

/**
 * Implements misc:d7:ctools-plugin:relationship command.
 */
final class Relationship extends BasePlugin {

  protected $name = 'misc:d7:ctools-plugin:relationship';
  protected $description = 'Generates CTools relationship plugin';
  protected $template = 'relationship';
  protected $subDirectory = 'plugins/relationships';

}
