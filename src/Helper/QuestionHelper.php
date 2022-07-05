<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
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
   */
  private int $counter = 0;

  /**
   * {@inheritdoc}
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question): mixed {

    // Input is not supplied with 'answer' option when the generator was started
    // from the Navigation command.
    $answers = $input->hasOption('answer') ? $input->getOption('answer') : NULL;

    if ($answers && \array_key_exists($this->counter, $answers)) {
      $answer = $this->askDry($output, $question, $answers);
    }
    else {
      $answer = parent::ask($input, $output, $question);
    }

    $this->counter++;
    return $answer;
  }

  /**
   * Prints to output question and answer.
   */
  protected function askDry(OutputInterface $output, Question $question, array $answers): mixed {

    if ($output instanceof ConsoleOutputInterface) {
      $output = $output->getErrorOutput();
    }

    $answer = $answers[$this->counter];

    $this->writePrompt($output, $question);

    $output->write("$answer\n");

    if ($answer === NULL) {
      $answer = $question->getDefault();
    }
    elseif ($question instanceof ConfirmationQuestion) {
      $answer = (bool) \preg_match('/^Ye?s?$/i', $answer);
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
        $answer = $choices[$answer] ?? NULL;
      }
    }
    return $answer;
  }

  /**
   * {@inheritdoc}
   */
  protected function writePrompt(OutputInterface $output, Question $question): void {
    // @todo Remove this once the following issue is resolved.
    // @see https://github.com/symfony/symfony/issues/39946
    $style = new OutputFormatterStyle('white', 'blue', ['bold']);
    $output->getFormatter()->setStyle('title', $style);

    $question_text = $question->getQuestion();
    $default_value = $question->getDefault();

    // Do not change formatted title.
    if (!\str_starts_with($question_text, '<title>')) {
      $question_text = "\n <info>$question_text</info>";

      if ($question instanceof ConfirmationQuestion && \is_bool($default_value)) {
        $default_value = $default_value ? 'Yes' : 'No';
      }

      if ($default_value !== NULL && $default_value !== '') {
        $question_text .= " [<comment>$default_value</comment>]:";
      }
      // No need to append colon if the text ends with a question mark.
      elseif (!\str_ends_with($question->getQuestion(), '?')) {
        $question_text .= ':';
      }
    }

    $output->writeln($question_text);

    if ($question instanceof ChoiceQuestion) {
      $max_width = \max(\array_map([self::class, 'width'], \array_keys($question->getChoices())));
      $messages = [];
      foreach ($question->getChoices() as $key => $value) {
        $key = \str_pad((string) $key, $max_width, pad_type: \STR_PAD_LEFT);
        $messages[] = '  [<info>' . $key . '</info>] ' . $value;
      }
      $output->writeln($messages);
    }

    $output->write(' ➤ ');
  }

  /**
   * {@inheritdoc}
   */
  protected function writeError(OutputInterface $output, \Exception $error): void {
    // Add one-space indentation to comply with DCG output style.
    $output->writeln(' <error>' . $error->getMessage() . '</error>');
  }

}
