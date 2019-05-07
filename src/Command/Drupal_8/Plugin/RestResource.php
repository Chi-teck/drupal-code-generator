<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:rest-resource command.
 */
class RestResource extends PluginGenerator {

  protected $name = 'd8:plugin:rest-resource';
  protected $description = 'Generates rest resource plugin';
  protected $alias = 'rest-resource';
  protected $label = 'REST resource';
  protected $classSuffix = 'Resource';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/rest/resource/{class}.php')
      ->template('d8/plugin/rest-resource.twig');
  }

}
