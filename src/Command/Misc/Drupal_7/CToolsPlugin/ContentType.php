<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Application;

/**
 * Implements misc:d7:ctools-plugin:content-type command.
 */
final class ContentType extends BasePlugin {

  protected string $name = 'misc:d7:ctools-plugin:content-type';
  protected string $description = 'Generates CTools content type plugin';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/ctools-plugin/content-type';
  protected string $template = 'content-type';
  protected string $subDirectory = 'plugins/content_types';

}
