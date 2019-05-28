<?php

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:views:style command.
 */
class Style extends PluginGenerator {

  protected $name = 'plugin:views:style';
  protected $description = 'Generates views style plugin';
  protected $alias = 'views-style';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the plugin configurable?');

    $this->addFile('src/Plugin/views/style/{class}.php')
      ->path('src/Plugin/views/style/{class}.php')
      ->template('plugin/views/style-plugin');

    $this->addFile('templates/views-style-{plugin_id|u2h}.html.twig')
      ->template('plugin/views/style-template');

    $this->addFile('{machine_name}.module')
      ->headerTemplate('file-docs/module')
      ->template('plugin/views/style-preprocess')
      ->action(Asset::APPEND)
      ->headerSize(7);

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('plugin/views/style-schema');
    }

  }

}
