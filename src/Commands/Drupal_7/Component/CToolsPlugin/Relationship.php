<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

/**
 * Implements generate:d7:component:ctools-plugin:relationship command.
 */
class Relationship extends BasePlugin {

  protected static $name = 'd7:component:ctools-plugin:relationship';
  protected static $description = 'Generate CTools relationship plugin';
  protected $template = 'd7/ctools-relationship-plugin.twig';

}
