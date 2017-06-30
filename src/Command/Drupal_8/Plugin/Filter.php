<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements d8:plugin:filter command.
 */
class Filter extends BaseGenerator {

  protected $name = 'd8:plugin:filter';
  protected $description = 'Generates filter plugin';
  protected $alias = 'filter';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $filter_types = [
      'TYPE_HTML_RESTRICTOR' => 'HTML restrictor',
      'TYPE_MARKUP_LANGUAGE' => 'Markup language',
      'TYPE_TRANSFORM_IRREVERSIBLE' => 'Irreversible transformation',
      'TYPE_TRANSFORM_REVERSIBLE' => 'Reversible transformation',
    ];
    $choices = array_values($filter_types);
    // Start choices list form '1'.
    array_unshift($choices, NULL);
    unset($choices[0]);
    $questions['filter_type'] = new ChoiceQuestion('Filter type', $choices);

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);
    $vars['filter_type'] = array_search($vars['filter_type'], $filter_types);

    $path = 'src/Plugin/Filter/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/plugin/filter.twig', $vars);
  }

}
