<?php

namespace DrupalCodeGenerator\Tests;

use Symfony\Component\Console\Helper\QuestionHelper as BaseHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Question helper without autocomplete.
 */
class QuestionHelper extends BaseHelper {

  /**
   * {@inheritdoc}
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question) {
    $question->setAutocompleterValues(NULL);
    $answer = parent::ask($input, $output, $question);
    // Write line after each input to make test output more readable.
    $output->writeln('');
    return $answer;
  }

}
