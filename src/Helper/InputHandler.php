<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Question;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generator input handler.
 */
class InputHandler extends Helper {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'dcg_input_handler';
  }

  /**
   * Interact with the user and create variables for Twig templates.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $questions
   *   List of questions that the user should answer. Each question is a
   *   numeric array including the following items.
   *     0 - string - question text.
   *     1 - string|callable|null - default value or callback.
   *     2 - callable|null - validation callback.
   *     3 - array|null - autocomplete suggestions.
   *     4 - callable|null - condition callback.
   *
   * @return array
   *   Template variables.
   */
  public function collectVars(InputInterface $input, OutputInterface $output, array $questions) {

    $vars = [];

    if ($answers_raw = $input->getOption('answers')) {
      $answers = json_decode($answers_raw, TRUE);
      if (!is_array($answers)) {
        throw new InvalidOptionException('Answers should be encoded in JSON format.');
      }
    }

    // Let third party applications modify these questions.
    if ($this->getHelperSet()->has('dcg_input_preprocessor')) {
      $this->getHelperSet()->get('dcg_input_preprocessor')->preprocess($questions, $this);
    }

    /** @var \DrupalCodeGenerator\Command\GeneratorInterface $command */
    $command = $this->getHelperSet()->getCommand();
    $directory = $command->getDirectory();
    foreach ($questions as $name => $question) {

      // Support array syntax.
      if (is_array($question)) {
        list($question_text, $default_value, $validator, $suggestions, $condition) = array_pad($question, 5, NULL);
        $question = new Question($question_text, $default_value);
        $question->setValidator($validator);
        $question->setAutocompleterValues($suggestions);
        $question->setCondition($condition);
      }

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

          case 'plugin_id':
            $default_value = [Utils::class, 'defaultPluginId'];
            break;
        }
      }

      if (is_callable($default_value)) {
        // Do not treat simple strings as callable because they may match PHP
        // builtin functions.
        if (!is_string($default_value) || strpos('::', $default_value) !== FALSE) {
          $default_value = call_user_func($default_value, $vars);
        }
      }
      $question->setDefault($default_value);

      $validator = $question->getValidator();
      if ($validator === NULL) {
        switch ($name) {
          case 'machine_name':
          case 'plugin_id':
            $validator = [Utils::class, 'validateMachineName'];
            break;

          case 'class':
            $validator = [Utils::class, 'validateClassName'];
            break;

          // Make the value required if no validators were provided.
          default:
            $validator = [Utils::class, 'validateRequired'];
        }
        $question->setValidator($validator);
      }

      $error = FALSE;
      do {
        // Do not ask if valid answer was passed through command line arguments.
        if (!$error && isset($answers[$name])) {
          $answer = $answers[$name];
        }
        else {
          // Check if this question should be skipped.
          if (!$question->checkCondition($vars)) {
            continue;
          }
          $answer = $this->ask(
            $input,
            $output,
            $question
          );

          $error = FALSE;
        }

      } while ($error);

      $vars[$name] = $answer;
    }

    return $vars;
  }

  /**
   * Asks a question to the user.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param Question $question
   *   The question to ask.
   *
   * @return string
   *   The user answer.
   */
  protected function ask(InputInterface $input, OutputInterface $output, Question $question) {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');

    $default_value = $question->getDefault();
    $question_text = $question->getQuestion();

    // Format question text.
    $question_text = "<info>$question_text</info>";
    if ($default_value) {
      $question_text .= " [<comment>$default_value</comment>]";
    }
    $question_text .= ': ';

    $question->setQuestion($question_text);

    $answer = $question_helper->ask(
      $input,
      $output,
      $question
    );

    return $answer;
  }

}
