<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Output style helpers.
 */
interface OutputStyleInterface extends StyleInterface, OutputInterface {

  /**
   * Asks a question to the user.
   */
  public function askQuestion(Question $question);

  /**
   * Prints horizontal rule.
   */
  public function rule(int $length) :void;

  /**
   * Builds console table.
   */
  public function buildTable(array $headers, array $rows) :Table;

}
