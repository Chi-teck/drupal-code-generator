<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

/**
 * Dumper options.
 */
final class DumperOptions {

  /**
   * Options constructor.
   */
  public function __construct(?bool $replace, bool $dry_run, bool $full_path) {
    $this->replace = $replace;
    $this->dryRun = $dry_run;
    $this->fullPath = $full_path;
  }

  /**
   * Replace flag.
   *
   * A flag indicating whether or not the files can be replaced. If not set the
   * user will be prompted to confirm replacing of each existing file.
   *
   * @var bool|null
   */
  public $replace;

  /**
   * Print assets to stdout instead of dumping them to file system.
   *
   * @var bool
   */
  public $dryRun;

  /**
   * Print full path to dumped assets.
   *
   * @var bool
   */
  public $fullPath;

}
