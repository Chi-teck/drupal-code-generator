<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class KernelAdvanced extends AdvancedBase {

  protected $name = 'd8:test:kernel-advanced';
  protected $description = 'Generates advanced kernel based test';
  protected $alias = 'kernel-test-advanced';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    parent::advancedTypeInteraction($input, $output);
    if ($this->type) {

      // Let's get Questions for specific type.
      $default_questions = $this->getTypeQuestions($this->type);

      // Let's map default questions.
      $default_questions += Utils::moduleQuestions();

      $default_questions['class'] = new Question('Class', 'ExampleTest');
      $default_questions['class']->setValidator([Utils::class, 'validateClassName']);

      $this->collectVars($input, $output, $default_questions);

      $this->addFile()
        ->path("tests/src/Kernel/{class}.php")
        ->template("d8/test/kernel-advanced/{$this->type}.twig");
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
      'service' => 'Service',
    ];

    return $options;
  }
}
