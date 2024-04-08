<?php

declare(strict_types=1);

namespace Drupal\foo;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the example entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class FooExampleAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    if ($account->hasPermission($this->entityType->getAdminPermission())) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    return match($operation) {
      'view' => AccessResult::allowedIfHasPermission($account, 'view foo_example'),
      'update' => AccessResult::allowedIfHasPermission($account, 'edit foo_example'),
      'delete' => AccessResult::allowedIfHasPermission($account, 'delete foo_example'),
      'delete revision' => AccessResult::allowedIfHasPermission($account, 'delete foo_example revision'),
      'view all revisions', 'view revision' => AccessResult::allowedIfHasPermissions($account, ['view foo_example revision', 'view foo_example']),
      'revert' => AccessResult::allowedIfHasPermissions($account, ['revert foo_example revision', 'edit foo_example']),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create foo_example', 'administer foo_example types'], 'OR');
  }

}
