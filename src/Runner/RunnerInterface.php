<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Runner;

use DrupalCodeGenerator\Application;

interface RunnerInterface {

  /**
   * Runs DCG application and returns exit code.
   */
  public function run(Application $application): int;

}
