<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\user\PermissionHandlerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about permissions.
 *
 * @todo Create a test for this.
 */
final class PermissionInfo extends Helper {

  /**
   * Constructs the helper.
   */
  public function __construct(
    private readonly PermissionHandlerInterface $permissionHandler,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'permission_info';
  }

  /**
   * Gets names of all available permissions.
   *
   * @psalm-return list<string>
   * @psalm-suppress MoreSpecificReturnType
   */
  public function getPermissionNames(): array {
    /** @psalm-suppress LessSpecificReturnStatement */
    return \array_keys($this->permissionHandler->getPermissions());
  }

}
