<?php

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:filter command.
 */
final class Filter extends PluginGenerator {

  protected $name = 'plugin:filter';
  protected $description = 'Generates filter plugin';
  protected $alias = 'filter';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $filter_types = [
      'TYPE_HTML_RESTRICTOR' => 'HTML restrictor',
      'TYPE_MARKUP_LANGUAGE' => 'Markup language',
      'TYPE_TRANSFORM_IRREVERSIBLE' => 'Irreversible transformation',
      'TYPE_TRANSFORM_REVERSIBLE' => 'Reversible transformation',
    ];
    $vars['filter_type'] = $this->choice('Filter type', $filter_types);

    $this->addFile('src/Plugin/Filter/{class}.php', 'filter');
    $this->addSchemaFile()->template('schema');
  }

}
