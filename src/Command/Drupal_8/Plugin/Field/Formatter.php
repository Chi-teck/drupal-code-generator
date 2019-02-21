<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
    $questions = Utils::moduleQuestions();
    $questions += Utils::pluginQuestions('Formatter');
    $questions['configurable'] = new ConfirmationQuestion('Make the formatter configurable?', FALSE);

    $vars = $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/Field/FieldFormatter/{class}.php')
      ->template('d8/plugin/field/formatter.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/field/formatter-schema.twig')
        ->action('append');
    }

  }

}
