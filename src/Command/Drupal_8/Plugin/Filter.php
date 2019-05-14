<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:filter command.
 */
class Filter extends PluginGenerator {

  protected $name = 'd8:plugin:filter';
  protected $description = 'Generates filter plugin';
  protected $alias = 'filter';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $filter_types = [
      'TYPE_HTML_RESTRICTOR' => 'HTML restrictor',
      'TYPE_MARKUP_LANGUAGE' => 'Markup language',
      'TYPE_TRANSFORM_IRREVERSIBLE' => 'Irreversible transformation',
      'TYPE_TRANSFORM_REVERSIBLE' => 'Reversible transformation',
    ];
    $vars['filter_type'] = $this->choice('Filter type', $filter_types);

    $this->addFile('src/Plugin/Filter/{class}.php')
      ->template('d8/plugin/filter');

    $this->addSchemaFile()->template('d8/plugin/filter-schema');
  }

}
