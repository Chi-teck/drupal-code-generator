<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:views:style command.
 */
final class Style extends PluginGenerator {

  protected string $name = 'plugin:views:style';
  protected string $description = 'Generates views style plugin';
  protected string $alias = 'views-style';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/views/style';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the plugin configurable?');

    $this->addFile('src/Plugin/views/style/{class}.php')
      ->template('style');

    $this->addFile('templates/views-style-{plugin_id|u2h}.html.twig')
      ->template('template');

    $this->addFile('{machine_name}.module')
      ->headerTemplate('_lib/file-docs/module')
      ->template('preprocess')
      ->appendIfExists()
      ->headerSize(7);

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }

  }

}
