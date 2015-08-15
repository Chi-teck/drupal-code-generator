<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

/**
 * Implements d7:component:ctools-plugin:content-type command.
 */
class ContentType extends BasePlugin {

  protected $name = 'd7:component:ctools-plugin:content-type';
  protected $description = 'Generate CTools content type plugin';
  protected $template = 'd7/ctools-content-type-plugin.twig';

}
