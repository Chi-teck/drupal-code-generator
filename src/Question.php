<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question as BaseQuestion;

class Question extends BaseQuestion {

  /**
   * @var callable
   */
  protected $condition;

  /**
   * Constructs question object.
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
   * @param $default
   */
  public function setQuestion($question) {
    // Set through the constructor because $question is private property.
    $this->__construct($question, $this->getDefault());
  }

  /**
   * @param $default
   */
  public function setDefault($default) {
    // Set through the constructor because $default is private property.
    $this->__construct($this->getQuestion(), $default);
  }

  /**
   * @param mixed $condition
   */
  public function setCondition($condition) {
    $this->condition = $condition;
  }

  /**
   * @return mixed
   */
  public function getCondition() {
    return $this->condition;
  }

  /**
   * @param $vars
   * @return bool|callable
   */
  public function checkCondition($vars) {
    $condition = $this->condition;
    if (is_callable($condition)) {
      return $condition($vars);
    }
    return $condition === NULL ? TRUE : $condition;
  }

  /**
   * Returns the confirmation normalizer.
   *
   * @return callable
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
