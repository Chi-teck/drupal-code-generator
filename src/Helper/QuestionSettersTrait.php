<?php

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements missing Question setters.
 */
trait QuestionSettersTrait {

  /**
   * Sets question text.
   *
   * @param \Symfony\Component\Console\Question\Question $question
   *   The question to update.
   * @param string $question_text
   *   The question text.
   */
  protected function setQuestionText(Question $question, string $question_text) :void {
    // Choice question has a different constructor signature.
    if ($question instanceof ChoiceQuestion) {
      $question->__construct($question_text, $question->getChoices(), $question->getDefault());
    }
    else {
      $question->__construct($question_text, $question->getDefault());
    }
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
