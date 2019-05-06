<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\PluginGenerator;

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
      ->template('d8/plugin/views/style-plugin.twig');

    $this->addFile('templates/views-style-' . str_replace('_', '-', $vars['plugin_id']) . '.html.twig')
      ->template('d8/plugin/views/style-template.twig');

    $this->addFile('{machine_name}.module')
      ->headerTemplate('d8/file-docs/module.twig')
      ->template('d8/plugin/views/style-preprocess.twig')
      ->action('append')
      ->headerSize(7);

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/views/style-schema.twig')
        ->action('append');
    }

  }

}
