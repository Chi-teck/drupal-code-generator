<?php declare(strict_types=1);

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
  protected $path;

  /**
   * Asset mode.
   *
   * @var int
   */
  protected $mode;

  /**
   * Template variables.
   *
   * @var array
   */
  protected $vars = [];

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
    return $this->replaceTokens($this->path);
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
   * Getter for asset vars.
   *
   * @return array
   *   Asset variables.
   */
  public function getVars(): array {
    return $this->vars;
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
   * Setter for asset vars.
   *
   * @param array $vars
   *   Asset template variables.
   *
   * @return self
   *   The asset.
   */
  public function vars(array $vars): self {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Implements the magic __toString() method.
   */
  public function __toString(): string {
    return $this->getPath();
  }

  /**
   * Replaces all tokens in a given string with appropriate values.
   */
  protected function replaceTokens(string $text): ?string {
    return Utils::replaceTokens($text, $this->vars);
  }

}
