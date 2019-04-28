<?php

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Helper\QuestionHelper as BaseQuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * The QuestionHelper class provides helpers to interact with the user.
 */
class QuestionHelper extends BaseQuestionHelper {

  /**
   * Counter to match questions and answers.
   *
   * @var int
   */
  private $counter = 0;

  /**
   * {@inheritdoc}
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question) {

    // Input is not supplied with 'answer' option when the generator was started
    // from the Navigation command.
    $answers = $input->hasOption('answer') ? $input->getOption('answer') : FALSE;

    if ($answers && array_key_exists($this->counter, $answers)) {

      if ($output instanceof ConsoleOutputInterface) {
        $output = $output->getErrorOutput();
      }

      $answer = $answers[$this->counter];

      $this->writePrompt($output, $question);
      $output->write($answer . "\n");

      if ($answer === NULL) {
        $answer = $question->getDefault();
      }
      elseif ($question instanceof ConfirmationQuestion) {
        $answer = preg_match('/^Ye?s?$/i', $answer);
      }

      if ($validator = $question->getValidator()) {
        try {
          $answer = $validator($answer);
        }
        catch (\UnexpectedValueException $exception) {
          // UnexpectedValueException can be a result of wrong user input. So
          // no need to render the exception in details as
          // Application::renderException() does.
          $this->writeError($output, $exception);
          exit(1);
        }
      }
      elseif ($question instanceof ChoiceQuestion) {
        $choices = $question->getChoices();
        if ($question->isMultiselect()) {
          // @todo Support multiselect.
        }
        else {
          $answer = $choices[$answer] ?? $choices[$answer];
        }
      }

    }
    else {
      $answer = parent::ask($input, $output, $question);
    }

    $this->counter++;
    return $answer;
  }

  /**
   * {@inheritdoc}
   */
  protected function writePrompt(OutputInterface $output, Question $question) {

    $question_text = $question->getQuestion();
    $default_value = $question->getDefault();

    // Do not change formatted title.
    if (strpos($question_text, '<title>') === FALSE) {
      $question_text = "\n <info>$question_text</info>";

      if ($question instanceof ConfirmationQuestion && is_bool($default_value)) {
        $default_value = $default_value ? 'Yes' : 'No';
      }
      if (strlen($default_value)) {
        $question_text .= " [<comment>$default_value</comment>]";
      }

      // No need to append colon if the text ends with a question mark.
      if (strlen($default_value) || $question->getQuestion()[-1] != '?') {
        $question_text .= ':';
      }
    }

    $output->write($question_text);

    if ($question instanceof ChoiceQuestion) {
      $max_width = max(array_map([$this, 'strlen'], array_keys($question->getChoices())));

      $output->writeln('');
      $messages = [];
      $choices = $question->getChoices();
      foreach ($choices as $key => $value) {
        $width = $max_width - $this->strlen($key);
        $messages[] = '  [<info>' . $key . str_repeat(' ', $width) . '</info>] ' . $value;
      }
      $output->writeln($messages);

      $output->write(count($choices) <= 10 ? '  ➤➤➤ ' : '  ➤➤➤➤ ');
    }
    else {
      $output->write("\n ➤ ");
    }

  }

}
