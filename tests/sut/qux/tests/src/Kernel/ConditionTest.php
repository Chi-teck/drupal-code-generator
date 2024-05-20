<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * A test for condition plugin.
 */
#[Group('DCG')]
final class ConditionTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testCondition(): void {
    /** @var \Drupal\Core\Condition\ConditionInterface $condition */
    $condition = $this->container
      ->get('plugin.manager.condition')
      ->createInstance('example');

    self::assertSame('Example: ', $condition->summary());

    self::assertTrue($condition->execute());

    $condition->setConfig('negate', TRUE);
    self::assertFalse($condition->execute());
  }

}
