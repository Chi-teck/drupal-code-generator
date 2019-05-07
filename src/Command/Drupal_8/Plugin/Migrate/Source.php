<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements d8:plugin:migrate:source command.
 */
class Source extends PluginGenerator {

  protected $name = 'd8:plugin:migrate:source';
  protected $description = 'Generates migrate source plugin';
  protected $alias = 'migrate-source';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();

    $source_types = [
      'sql' => 'SQL',
      'other' => 'Other',
    ];
    $choices = Utils::prepareChoices($source_types);
    $questions['source_type'] = new ChoiceQuestion('Source type', $choices);

    $vars = &$this->collectVars($questions);
    $vars['base_class'] = $vars['source_type'] == 'sql' ? 'SqlBase' : 'SourcePluginBase';

    $this->addFile('src/Plugin/migrate/source/{class}.php')
      ->template('d8/plugin/migrate/source.twig');
  }

}
