<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question as BaseQuestion;

/**
 * Represents a generator question.
 *
 * @deprecated
 *  Use native Symfony console question.
 */
class Question extends BaseQuestion {

  /**
   * Sets question text.
   *
   * @param string $question
   *   The question text.
   */
  public function setQuestion($question) {
    // Set through the constructor because $question is private property.
    $this->__construct($question, $this->getDefault());
  }

  /**
   * Sets default answer.
   *
   * @param string|callable $default
   *   Default answer.
   */
  public function setDefault($default) {
    // Set through the constructor because $default is private property.
    $this->__construct($this->getQuestion(), $default);
  }

}
