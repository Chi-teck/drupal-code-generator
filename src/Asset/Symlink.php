<?php

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
   *
   * @var string
   */
  private $action = self::ACTION_REPLACE;

  /**
   * Symlink target.
   *
   * @var string
   */
  private $target;

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
  public function getTarget() {
    return $this->target;
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
   * Sets "replace" action.
   *
   * @return self
   *   The asset.
   */
  public function replaceIfExists() {
    $this->action = self::ACTION_REPLACE;
    return $this;
  }

  /**
   * Sets "skip" action.
   *
   * @return self
   *   The asset.
   */
  public function skipIfExists() {
    $this->action = self::ACTION_SKIP;
    return $this;
  }

}
