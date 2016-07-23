<?php

namespace Drupal\foo;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Node\NodeStorageInterface;

/**
 * Example service.
 */
class Example {

  /**
   * The entity query factory.
   *
   * @var QueryFactory
   */
  protected $entityQuery;

  /**
   * Node storage.
   *
   * @var NodeStorageInterface
   */
  protected $nodeStorage;

  /**
   * Constructs an Example object.
   *
   * @param QueryFactory $entity_query
   *   The entity query factory service.
   * @param EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(QueryFactory $entity_query, EntityTypeManagerInterface $entity_type_manager) {
    $this->entityQuery = $entity_query;
    $this->nodeStorage = $entity_type_manager->getStorage('node');
  }

  /**
   * Retrieves the last created node.
   */
  public function getLastNode() {
    $nids = $this->entityQuery->get('node')
      ->sort('created', 'DESC')
      ->range(0, 1)
      ->execute();

    $nid = reset($nids);
    return $nid ? $this->nodeStorage->load($nid) : FALSE;
  }

}
