<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility\Php8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * PHP 8 compatibility.
 */
trait AskTrait {

  public function ask(InputInterface $input, OutputInterface $output, Question $question): mixed {
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
