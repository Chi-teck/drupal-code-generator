<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility\Php8;

use Symfony\Component\Console\Question\Question;

/**
 * PHP 8 compatibility.
 */
trait AskQuestionTrait {

  public function askQuestion(Question $question): mixed {
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
