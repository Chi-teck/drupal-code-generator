<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:field:formatter command.
 */
class Formatter extends BaseGenerator {

  protected $name = 'd8:plugin:field:formatter';
  protected $description = 'Generates field formatter plugin';
  protected $alias = 'field-formatter';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']) . 'Formatter';

    $this->addFile()
      ->path('src/Plugin/Field/FieldFormatter/{class}.php')
      ->template('d8/plugin/field/formatter.twig');

    $this->addFile()
      ->path('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/field/formatter-schema.twig')
      ->action('append');
  }

}
