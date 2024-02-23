<?php

declare(strict_types=1);

// phpcs:disable

namespace DrupalCodeGenerator\Test\Functional;

use DrupalCodeGenerator\Helper\QuestionHelper as BaseHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Question helper without autocomplete.
 *
 * @todo Is it still needed?
 */
final class QuestionHelper extends BaseHelper {

  /**
   * {@inheritdoc}
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question): mixed {
    $answer = parent::ask($input, $output, $question);
    // Write line after each input to make test output more readable.
    $output->writeln('');
    return $answer;
  }

}
