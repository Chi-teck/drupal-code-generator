<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility\Php7;

use Symfony\Component\Console\Question\Question;

/**
 * PHP 7 compatibility.
 */
trait AskQuestionTrait {

  /**
   * Asks a question.
   *
   * @return mixed
   *   The answer.
   */
  public function askQuestion(Question $question) {
    return $this->compatAskQuestion($question);
  }

  /**
   * Asks a question.
   *
   * @return mixed
   *   The answer.
   */
  abstract protected function compatAskQuestion(Question $question);

}
