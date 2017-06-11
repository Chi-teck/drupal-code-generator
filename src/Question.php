<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question as BaseQuestion;

/**
 * Represents a generator question.
 */
class Question extends BaseQuestion {

  /**
   * Constructs question object.
   *
   * @param string $question
   *   The question text.
   * @param string|callable $default
   *   Default answer.
   * @param callable|null $validator
   *   (Optional) The validator for the question.
   */
  public function __construct($question, $default = NULL, $validator = NULL) {
    if (($default == 'yes' || $default == 'no') && !$this->getNormalizer()) {
      $this->setNormalizer($this->getConfirmationNormalizer($default));
    }
    $this->setValidator($validator);
    parent::__construct($question, $default);
  }

  /**
   * Sets question text.
   *
   * @param string $question
   *   The question text.
   */
  public function setQuestion($question) {
    // Set through the constructor because $question is private property.
    $this->__construct($question, $this->getDefault(), $this->getValidator());
  }

  /**
   * Sets default answer.
   *
   * @param string|callable $default
   *   Default answer.
   */
  public function setDefault($default) {
    // Set through the constructor because $default is private property.
    $this->__construct($this->getQuestion(), $default, $this->getValidator());
  }

  /**
   * Returns the confirmation normalizer.
   *
   * @param string|callable $default
   *   Default answer.
   *
   * @return callable
   *   Normalizer for confirmation questions.
   */
  private function getConfirmationNormalizer($default) {
    return function ($answer) use ($default) {

      if (is_bool($answer)) {
        return $answer;
      }

      $answer_is_true = (bool) preg_match('/^y/i', $answer);
      if ($default === FALSE) {
        return $answer && $answer_is_true;
      }

      return !$answer || $answer_is_true;
    };
  }

}
