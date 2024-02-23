<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\Core\Entity\Query\QueryInterface;

/**
 * @todo Add plugin description here.
 *
 * @EntityReferenceSelection(
 *   id = "contact_message_selection",
 *   label = @Translation("Contact message selection"),
 *   group = "contact_message_selection",
 *   entity_types = {"contact_message"},
 * )
 */
final class ContactMessageSelection extends DefaultSelection {

  /**
   * {@inheritdoc}
   */
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS'): QueryInterface {
    $query = parent::buildEntityQuery($match, $match_operator);
    // @todo Modify the query here.
    return $query;
  }

}
