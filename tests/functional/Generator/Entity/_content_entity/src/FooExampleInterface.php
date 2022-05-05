<?php

namespace Drupal\foo;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an example entity type.
 */
interface FooExampleInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
