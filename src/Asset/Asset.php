<?php

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Utils;

/**
 * Base class for assets.
 */
abstract class Asset {

  /**
   * Asset path.
   *
   * @var string
   */
  private $path;

  /**
   * Asset mode.
   *
   * @var int
   */
  private $mode;

  /**
   * Asset constructor.
   */
  public function __construct(string $path) {
    $this->path = $path;
  }

  /**
   * Getter for asset path.
   *
   * @return string
   *   Asset path.
   */
  public function getPath(): string {
    return $this->path;
  }

  /**
   * Getter for asset mode.
   *
   * @return int
   *   Asset file mode.
   */
  public function getMode(): int {
    return $this->mode;
  }

  /**
   * Setter for asset mode.
   *
   * @param int $mode
   *   Asset mode.
   *
   * @return \DrupalCodeGenerator\Asset\Asset
   *   The asset.
   */
  public function mode(int $mode): Asset {
    if ($mode < 0000 || $mode > 0777) {
      throw new \InvalidArgumentException("Incorrect mode value $mode.");
    }
    $this->mode = $mode;
    return $this;
  }

  /**
   * Replaces tokens in asset properties.
   */
  public function replaceTokens(array $vars): void {
    $this->path = Utils::replaceTokens($this->path, $vars);
  }

  /**
   * Implements the magic __toString() method.
   */
  public function __toString(): string {
    return $this->path;
  }

}
