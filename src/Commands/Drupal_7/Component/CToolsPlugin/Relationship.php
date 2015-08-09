<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

/**
 * Implements generate:d7:component:ctools-plugin:relationship command.
 */
class Relationship extends BasePlugin {

  protected $name = 'd7:component:ctools-plugin:relationship';
  protected $description = 'Generate CTools relationship plugin';
  protected $template = 'd7/ctools-relationship-plugin.twig';

}
