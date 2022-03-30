<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Style;

use DrupalCodeGenerator\Compatibility\GeneratorStyleCompatibilityInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface as SymfonyStyleInterface;

/**
 * Output style helpers.
 */
interface GeneratorStyleInterface extends SymfonyStyleInterface, OutputInterface, GeneratorStyleCompatibilityInterface {

  /**
   * Builds console table.
   */
  public function buildTable(array $headers, array $rows): Table;

  /**
   * Input getter.
   */
  public function getInput(): InputInterface;

  /**
   * Output getter.
   */
  public function getOutput(): OutputInterface;

  /**
   * Returns a new instance which makes use of stderr if available.
   */
  public function getErrorStyle(): self;

}
