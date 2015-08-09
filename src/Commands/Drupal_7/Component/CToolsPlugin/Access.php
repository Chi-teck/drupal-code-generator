<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

/**
 * Implements generate:d7:component:ctools-plugin:access command.
 */
class Access extends BasePlugin {

  protected $name = 'd7:component:ctools-plugin:access';
  protected $description = 'Generate CTools access plugin';
  protected $template = 'd7/ctools-access-plugin.twig';

}
