<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Generator input handler.
 */
class InputHandler extends Helper {

  /**
   * Asked questions.
   *
   * @var array
   */
  protected $askedQuestions = [];

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'input_handler';
  }

  /**
   * Interacts with the user and returns variables for templates.
   *
   * @param \Symfony\Component\Console\Question\Question[] $questions
   *   List of questions that the user should answer.
   * @param array $vars
   *   Array of predefined template variables.
   *
   * @return array
   *   Template variables.
   */
  public function collectVars(array $questions, array $vars = []) :array {

    /** @var \DrupalCodeGenerator\Helper\OutputStyleFactory $output_style_factory */
    $output_style_factory = $this->getHelperSet()->get('output_style_factory');
    $io = $output_style_factory->getOutputStyle();

    /** @var \DrupalCodeGenerator\Command\GeneratorInterface $command */
    $command = $this->getHelperSet()->getCommand();
    $directory = $command->getDirectory();

    foreach ($questions as $name => $question) {

      if (in_array($name, $this->askedQuestions)) {
        continue;
      }
      $this->askedQuestions[] = $name;

      $default_value = $question->getDefault();

      // Make some assumptions based on question name.
      if ($default_value === NULL) {
        switch ($name) {
          case 'name':
            $root_directory = basename(Utils::getExtensionRoot($directory) ?: $directory);
            $default_value = Utils::machine2human($root_directory);
            break;

          case 'machine_name':
            $default_value = function (array $vars) use ($directory) {
              return Utils::human2machine(isset($vars['name']) ? $vars['name'] : basename($directory));
            };
            break;
        }
      }

      // Turn the callback into a value acceptable for Symfony question helper.
      if (is_callable($default_value)) {
        // Do not treat simple strings as callable because they may match PHP
        // builtin functions.
        if (!is_string($default_value) || strpos('::', $default_value) !== FALSE) {
          $default_value = call_user_func($default_value, $vars);
        }
      }
      // Default value may have tokens.
      if ($default_value) {
        $default_value = Utils::replaceTokens($default_value, $vars);
      }
      $this->setQuestionDefault($question, $default_value);

      $vars[$name] = $io->askQuestion($question);
    }

    return $vars;
  }

  /**
   * Sets question default value.
   *
   * @param \Symfony\Component\Console\Question\Question $question
   *   The question to update.
   * @param mixed $default_value
   *   Default value for the question.
   */
  protected function setQuestionDefault(Question $question, $default_value) :void {
    if ($question instanceof ChoiceQuestion) {
      $question->__construct($question->getQuestion(), $question->getChoices(), $default_value);
    }
    else {
      $question->__construct($question->getQuestion(), $default_value);
    }
  }

}
