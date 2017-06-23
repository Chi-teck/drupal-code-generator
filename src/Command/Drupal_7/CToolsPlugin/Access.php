<?php

namespace DrupalCodeGenerator\Command\Drupal_7\CToolsPlugin;

/**
 * Implements d7:ctools-plugin:access command.
 */
class Access extends BasePlugin {

  protected $name = 'd7:ctools-plugin:access';
  protected $description = 'Generates CTools access plugin';
  protected $template = 'd7/ctools-plugin/access.twig';
  protected $subDirectory = 'plugins/access';

}
