<?php

namespace Drupal\foo;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an example entity type.
 */
interface FooExampleInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the example creation timestamp.
   *
   * @return int
   *   Creation timestamp of the example.
   */
  public function getCreatedTime();

  /**
   * Sets the example creation timestamp.
   *
   * @param int $timestamp
   *   The example creation timestamp.
   *
   * @return \Drupal\foo\FooExampleInterface
   *   The called example entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the example status.
   *
   * @return bool
   *   TRUE if the example is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the example status.
   *
   * @param bool $status
   *   TRUE to enable this example, FALSE to disable.
   *
   * @return \Drupal\foo\FooExampleInterface
   *   The called example entity.
   */
  public function setStatus($status);

}
