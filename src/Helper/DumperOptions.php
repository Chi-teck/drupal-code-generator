<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

/**
 * Dumper options.
 */
final class DumperOptions {

  /**
   * Options constructor.
   */
  public function __construct(?bool $replace) {
    $this->replace = $replace;
  }

  /**
   * Replace flag.
   *
   * A flag indicating whether the files can be replaced. If not set the
   * user will be prompted to confirm replacing of each existing file.
   */
  public ?bool $replace;

}
