<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question as BaseQuestion;

/**
 * Represents a generator question.
 */
class Question extends BaseQuestion {

  /**
   * A flag to determine whether or not the question should be asked.
   *
   * @var bool|callable
   */
  protected $condition;

  /**
   * Constructs question object.
   *
   * @param string $question
   *   The question text.
   * @param string|callable $default
   *   Default answer.
   * @param callable $validator
   *   (Optional) The validator for the question.
   */
  public function __construct($question, $default = NULL, $validator = [Utils::class, 'validateRequired']) {
    if (($default == 'yes' || $default == 'no') && !$this->getNormalizer()) {
      $this->setNormalizer($this->getConfirmationNormalizer($default));
    }

    if ($validator && !$this->getValidator()) {
      $this->setValidator($validator);
    }

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

  /**
   * Sets question condition.
   *
   * @param mixed $condition
   *   Question condition.
   */
  public function setCondition($condition) {
    $this->condition = $condition;
  }

  /**
   * Returns question condition.
   *
   * @return mixed
   *   Question condition.
   */
  public function getCondition() {
    return $this->condition;
  }

  /**
   * Checks question condition.
   *
   * @param array $vars
   *   An associated array of variables (answers).
   *
   * @return bool|callable
   *   Whether or not the question should be asked.
   */
  public function checkCondition(array $vars) {
    $condition = $this->condition;
    if (is_callable($condition)) {
      return $condition($vars);
    }
    return $condition === NULL ? TRUE : $condition;
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
