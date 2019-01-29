<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:migrate:source command.
 */
class Source extends BaseGenerator {

  protected $name = 'd8:plugin:migrate:source';
  protected $description = 'Generates migrate source plugin';
  protected $alias = 'migrate-source';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = Utils::defaultQuestions();
    $questions['plugin_id'] = new Question('Plugin ID', '{machine_name}_example');
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);

    $source_types = [
      'sql' => 'SQL',
      'other' => 'Other',
    ];
    $choices = Utils::prepareChoices($source_types);
    $questions['source_type'] = new ChoiceQuestion('Source type', $choices);

    $vars = &$this->collectVars($input, $output, $questions);

    $unprefixed_plugin_id = preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);
    $vars['class'] = Utils::camelize($unprefixed_plugin_id);
    $vars['base_class'] = $vars['source_type'] == 'sql' ? 'SqlBase' : 'SourcePluginBase';

    $this->addFile()
      ->path('src/Plugin/migrate/source/{class}.php')
      ->template('d8/plugin/migrate/source.twig');
  }

}
