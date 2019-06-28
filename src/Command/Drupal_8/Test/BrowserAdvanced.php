<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class BrowserAdvanced extends AdvancedBase {

  protected $name = 'd8:test:browser-advanced';
  protected $description = 'Generates advanced browser based test';
  protected $alias = 'browser-test-advanced';

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
      $default_questions['class']->setValidator([
        Utils::class,
        'validateClassName'
      ]);

      $this->collectVars($input, $output, $default_questions);
      $twig_path = "d8/test/browser-advanced/{$this->type}.twig";
      switch ($this->type) {

        case 'block':
          $twig_path = "d8/test/browser-advanced/plugin/{$this->type}.twig";
          break;
      }

      $this->addFile()
        ->path("tests/src/Functional/{class}.php")
        ->template($twig_path);
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
      'controller' => 'Controller'
    ];

    switch ($type) {

      case 'plugin':
        $options['plugin'] = [
          'block' => 'Block',
        ];
        break;
    }

    if ($type && array_key_exists($type, $options)) {
      $options = $options[$type];
    }

    return $options;
  }

}
