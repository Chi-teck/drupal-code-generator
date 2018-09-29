<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Implements d8:plugin:field:widget command.
 */
class Widget extends BaseGenerator {

  protected $name = 'd8:plugin:field:widget';
  protected $description = 'Generates field widget plugin';
  protected $alias = 'field-widget';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();
    $questions['configurable'] = new ConfirmationQuestion('Make the widget configurable?', FALSE);

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']) . 'Widget';

    $this->addFile()
      ->path('src/Plugin/Field/FieldWidget/{class}.php')
      ->template('d8/plugin/field/widget.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/field/widget-schema.twig')
        ->action('append');
    }
  }

}
