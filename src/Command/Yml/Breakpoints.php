<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:breakpoints command.
 */
final class Breakpoints extends ThemeGenerator {

  protected $name = 'yml:breakpoints';
  protected $description = 'Generates a breakpoints yml file';
  protected $alias = 'breakpoints';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.breakpoints.yml', 'breakpoints');
  }

}
