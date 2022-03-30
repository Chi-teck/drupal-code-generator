<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility\Php7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * PHP 7 compatibility.
 */
trait AskTrait {

  /**
   * Asks a question.
   *
   * @return mixed
   *   The answer.
   */
  public function ask(InputInterface $input, OutputInterface $output, Question $question) {
    return $this->compatAsk($input, $output, $question);
  }

  /**
   * Asks a question.
   *
   * @return mixed
   *   The answer.
   */
  abstract protected function compatAsk(InputInterface $input, OutputInterface $output, Question $question);

}
