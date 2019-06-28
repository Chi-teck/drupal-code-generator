<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Abstract class AdvancedTest.
 */
abstract class AdvancedBase extends BaseGenerator {

  /**
   * Get answer for Options selected.
   */
  protected $type;

  /**
   * Interacts with the user and builds route variables.
   */
  protected function advancedTypeInteraction(InputInterface $input, OutputInterface $output) {

    // Prepare options for test creation.
    $default_types = $types = $this->getOptions();
    while(TRUE) {
      $choices = Utils::prepareChoices($types);
      $type_question = new ChoiceQuestion('Select Type', $choices, '');
      $type_answer = $this->ask($input, $output, $type_question);

      $this->type = array_search($type_answer, $types);

      $child_types = $this->getOptions($this->type);
      if (!is_array($child_types) || $child_types == $default_types) {
        break;
      }
      $types = $child_types;
    }
  }

  /**
   * Function to get options for questions.
   *
   * @param string $type
   *  Type of question need to retrieve.
   *
   * @return array $options
   *   Options to return.
   */
  protected function getOptions($type = NULL) {

    // Prepare options for test creation.
    $options = [
      'plugin' => 'Plugin',
      'controller' => 'Controller',
      'service' => 'Service',
    ];

    if ($type && array_key_exists($type, $options)) {
      $options = $options[$type];
    }

    return $options;
  }

  /**
   * Function to get options for questions.
   *
   * @param string $type
   *  Type of question need to retrieve.
   *
   * @return array $questions
   *   Options to return.
   */
  protected function getTypeQuestions($type = NULL) {

    $questions = [];

    switch ($type) {
      case 'block':
        $questions[$type] = new Question('Enter Block name', 'example');
        break;
      case 'field-type':
        $questions[$type] = new Question('Enter Field Type', 'example');
        break;
      case 'formatter':
        $questions[$type] = new Question('Enter Field Formatter', 'example');
        break;
      case 'controller':
        $questions['route_path'] = new Question('Route path', '/example/route');
        $questions['route_permission'] = new Question('Route permission', 'access content');
        break;
      case 'service':
        $questions[$type] = new Question('Service name', '{machine_name}.example');
        $questions[$type]->setValidator([Utils::class, 'validateServiceName']);
        break;
    }
    return $questions;
  }

}
