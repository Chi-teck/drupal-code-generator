<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Implements d8:plugin:field:type command.
 */
class Type extends BaseGenerator {

  protected $name = 'd8:plugin:field:type';
  protected $description = 'Generates field type plugin';
  protected $alias = 'field-type';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $questions['configurable_storage'] = new ConfirmationQuestion('Make the field storage configurable?', FALSE);
    $questions['configurable_instance'] = new ConfirmationQuestion('Make the field instance configurable?', FALSE);

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']) . 'Item';

    $this->addFile()
      ->path('src/Plugin/Field/FieldType/{class}.php')
      ->template('d8/plugin/field/type.twig');

    $this->addFile()
      ->path('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/field/type-schema.twig')
      ->action('append');
  }

}
