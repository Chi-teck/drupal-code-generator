<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Generators input handler.
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

    // Normalize questions.
    $questions = array_map(function ($question) {
      return array_pad($question, 5, NULL);
    }, $questions);

    // Let third party applications modify these questions.
    // @TODO: Create a test for this.
    if ($this->getHelperSet()->has('dcg_input_preprocessor')) {
      $this->getHelperSet()->get('dcg_input_preprocessor')->preprocess($questions, $this);
    }

    /** @var \DrupalCodeGenerator\Commands\GeneratorInterface $command */
    $command = $this->getHelperSet()->getCommand();
    $directory = $command->getDirectory();
    foreach ($questions as $name => $question) {
      list($question_text, $default_value, $validator, $suggestions, $condition) = $question;

      // Make some assumptions based on question name.
      if ($default_value === NULL) {
        switch ($name) {
          // TODO: Test default values.
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

      if ($validator === NULL) {
        switch ($name) {
          // TODO: Test this validation.
          case 'machine_name':
          case 'plugin_id':
            $validator = [Utils::class, 'validateMachineName'];
            break;

          case 'class':
            $validator = [Utils::class, 'validateClassName'];
            break;

          // By default all values are required.
          default:
            $validator = [Utils::class, 'validateRequired'];
        }
      }

      if (is_callable($default_value)) {
        // Do not treat simple strings as callable because they may match PHP
        // builtin functions.
        if (!is_string($default_value) || strpos('::', $default_value) !== FALSE) {
          $default_value = call_user_func($default_value, $vars);
        }
      }

      $error = FALSE;
      do {
        // Do not ask if valid answer was passed through command line arguments.
        if (!$error && isset($answers[$name])) {
          $answer = $answers[$name];
        }
        else {
          // Check if this question should be skipped.
          if (is_callable($condition) && !$condition($vars)) {
            continue;
          }
          $answer = $this->ask(
            $input,
            $output,
            $question_text,
            $default_value,
            $suggestions
          );
        }

        if (is_callable($validator) && ($error = $validator($answer))) {
          $output->writeln('<error>' . $error . '</error>');
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
   * @param string $question_text
   *   The text of the question.
   * @param string $default_value
   *   Default value for the question.
   * @param array $suggestions
   *   (optional) Autocomplete values.
   *
   * @return string
   *   The user answer.
   */
  protected function ask(InputInterface $input, OutputInterface $output, $question_text, $default_value, array $suggestions = NULL) {
    /** @var \Symfony\Component\Console\Helper\QuestionHelper $question_helper */
    $question_helper = $this->getHelperSet()->get('question');

    $question_text = "<info>$question_text</info>";
    if ($default_value) {
      $question_text .= " [<comment>$default_value</comment>]";
    }
    $question_text .= ': ';

    if ($default_value == 'yes' || $default_value == 'no') {
      $question = new ConfirmationQuestion($question_text, $default_value == 'yes');
    }
    else {
      $question = new Question($question_text, $default_value);
    }

    if ($suggestions) {
      $question->setAutocompleterValues($suggestions);
    }

    $answer = $question_helper->ask(
      $input,
      $output,
      $question
    );

    return $answer;
  }

}
