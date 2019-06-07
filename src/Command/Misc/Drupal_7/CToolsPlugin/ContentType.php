<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

/**
 * Implements misc:d7:ctools-plugin:content-type command.
 */
final class ContentType extends BasePlugin {

  protected $name = 'misc:d7:ctools-plugin:content-type';
  protected $description = 'Generates CTools content type plugin';
  protected $template = 'content-type';
  protected $subDirectory = 'plugins/content_types';

}
