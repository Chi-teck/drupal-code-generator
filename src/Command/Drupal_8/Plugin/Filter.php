<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
    $this->collectDefault();

    $filter_types = [
      'TYPE_HTML_RESTRICTOR' => 'HTML restrictor',
      'TYPE_MARKUP_LANGUAGE' => 'Markup language',
      'TYPE_TRANSFORM_IRREVERSIBLE' => 'Irreversible transformation',
      'TYPE_TRANSFORM_REVERSIBLE' => 'Reversible transformation',
    ];
    $choices = Utils::prepareChoices($filter_types);
    $questions['filter_type'] = new ChoiceQuestion('Filter type', $choices);

    $vars = &$this->collectVars($questions);
    $vars['filter_type'] = array_search($vars['filter_type'], $filter_types);

    $this->addFile('src/Plugin/Filter/{class}.php')
      ->template('d8/plugin/filter.twig');

    $this->addFile('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/filter-schema.twig')
      ->action('append');
  }

}
