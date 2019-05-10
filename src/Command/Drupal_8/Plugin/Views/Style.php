<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:views:style command.
 */
class Style extends PluginGenerator {

  protected $name = 'd8:plugin:views:style';
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
      ->template('d8/plugin/views/style-plugin');

    $this->addFile('templates/views-style-{plugin_id|u2h}.html.twig')
      ->template('d8/plugin/views/style-template');

    $this->addFile('{machine_name}.module')
      ->headerTemplate('d8/file-docs/module')
      ->template('d8/plugin/views/style-preprocess')
      ->action('append')
      ->headerSize(7);

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/views/style-schema')
        ->action('append');
    }

  }

}
