<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

/**
 * Implements misc:d7:ctools-plugin:access command.
 */
class Access extends BasePlugin {

  protected $name = 'misc:d7:ctools-plugin:access';
  protected $description = 'Generates CTools access plugin';
  protected $template = 'misc/d7/ctools-plugin/access';
  protected $subDirectory = 'plugins/access';

}
