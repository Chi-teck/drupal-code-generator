<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Attribute\EntityReferenceSelection;
use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * @todo Add plugin description here.
 */
#[EntityReferenceSelection(
  id: 'contact_message_selection',
  label: new TranslatableMarkup('Contact message selection'),
  group: 'contact_message_selection',
  weight: 1,
  entity_types: ['contact_message'],
)]
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
