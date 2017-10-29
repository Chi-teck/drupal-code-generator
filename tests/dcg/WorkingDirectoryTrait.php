<?php

namespace DrupalCodeGenerator\Tests;

use Symfony\Component\Filesystem\Filesystem;

/**
 * A trait for managing command working directory.
 */
trait WorkingDirectoryTrait {

  /**
   * Working directory.
   *
   * @var string
   */
  protected $directory;

  /**
   * Initialize working directory.
   */
  protected function initWorkingDirectory() {
    $this->directory = sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * Removes working directory.
   */
  protected function removeWorkingDirectory() {
    (new Filesystem())->remove($this->directory);
  }

}
