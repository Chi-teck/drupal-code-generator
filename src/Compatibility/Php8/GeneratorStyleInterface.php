<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility\Php8;

use Symfony\Component\Console\Question\Question;

/**
 * PHP 8 compatibility.
 */
interface GeneratorStyleInterface {

  /**
   * Asks a question to the user.
   *
   * @return mixed
   *   The answer.
   */
  public function askQuestion(Question $question): mixed;

}
