<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Classes.RequireAbstractOrFinal.ClassNeitherAbstractNorFinal

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Exception\SilentException;
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
 *
 * @todo Move answers queue in a separate helper.
 */
class QuestionHelper extends BaseQuestionHelper {

  /**
   * Counter to match questions and answers.
   *
   * @psalm-var int<0, max>
   */
  private int $counter = 0;

  /**
   * {@inheritdoc}
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question): mixed {
    // When the generator is started from the Navigation command the input is
    // not supplied with 'answer' option.
    $answers = $input->hasOption('answer') ? $input->getOption('answer') : [];

    if (!\array_key_exists($this->counter, $answers)) {
      return parent::ask($input, $output, $question);
    }

    // -- Simulate interaction.
    $answer = $answers[$this->counter++];

    if ($output instanceof ConsoleOutputInterface) {
      $output = $output->getErrorOutput();
    }
    $this->writePrompt($output, $question);
    $output->write("$answer\n");

    $answer ??= $question->getDefault();

    if ($validator = $question->getValidator()) {
      try {
        $answer = $validator($answer);
      }
      catch (\UnexpectedValueException $exception) {
        // The exception is a result of wrong user input. So no need to render
        // it in details as Application::renderException() does.
        $this->writeError($output, $exception);
        throw new SilentException($exception->getMessage(), previous: $exception);
      }
    }

    if ($question->isTrimmable() && \is_string($answer)) {
      $answer = \trim($answer);
    }

    if ($normalizer = $question->getNormalizer()) {
      $answer = $normalizer($answer);
    }

    return $answer;
  }

  /**
   * {@inheritdoc}
   */
  final protected function writePrompt(OutputInterface $output, Question $question): void {
    // @todo Remove this once the following issue is resolved.
    // @see https://github.com/symfony/symfony/issues/39946
    $style = new OutputFormatterStyle('white', 'blue', ['bold']);
    $output->getFormatter()->setStyle('title', $style);

    $question_text = $question->getQuestion();
    $default_value = $question->getDefault();

    // Navigation command formats questions itself.
    // @todo Check if the question is already formatted in a more generic way.
    if (!\str_starts_with($question_text, '<title>')) {
      $question_text = "\n <info>$question_text</info>";

      if ($default_value !== NULL && $default_value !== '') {
        if ($question instanceof ConfirmationQuestion) {
          // Confirmation question always has boolean default value.
          // @see \Symfony\Component\Console\Question\ConfirmationQuestion::__construct()
          $default_value = $default_value ? 'Yes' : 'No';
        }
        $question_text .= " [<comment>$default_value</comment>]:";
      }
      // Colon and question mark should not show up together.
      elseif (!\str_ends_with($question->getQuestion(), '?')) {
        $question_text .= ':';
      }
    }

    $output->writeln($question_text);

    if ($question instanceof ChoiceQuestion) {
      $choices = $question->getChoices();
      \assert(\count($choices) > 0);
      $max_width = \max(\array_map([self::class, 'width'], \array_keys($choices)));
      $messages = [];
      foreach ($choices as $key => $value) {
        // For numeric keys left padding makes more sense.
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
  final protected function writeError(OutputInterface $output, \Throwable $error): void {
    // Add one-space indentation to comply with DCG output style.
    $output->writeln(' <error>' . $error->getMessage() . '</error>');
  }

}
