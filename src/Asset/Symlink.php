<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Simple data structure to represent a symlink being generated.
 */
final class Symlink extends Asset {

  public const ACTION_REPLACE = 0x01;
  public const ACTION_SKIP = 0x04;

  /**
   * Action.
   *
   * An action to take if specified symlink already exists.
   */
  private int $action = self::ACTION_REPLACE;

  /**
   * Symlink target.
   */
  private string $target;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path, string $target) {
    parent::__construct($path);
    $this->target = $target;
    $this->mode(0644);
  }

  /**
   * Getter for symlink target.
   *
   * @return string
   *   Asset action.
   */
  public function getTarget(): string {
    return $this->replaceTokens($this->target);
  }

  /**
   * Getter for asset action.
   *
   * @return string|callable
   *   Asset action.
   */
  public function getAction() {
    return $this->action;
  }

  /**
   * Sets the "replace" action.
   */
  public function replaceIfExists(): self {
    $this->action = self::ACTION_REPLACE;
    return $this;
  }

  /**
   * Sets the "skip" action.
   */
  public function skipIfExists(): self {
    $this->action = self::ACTION_SKIP;
    return $this;
  }

}
