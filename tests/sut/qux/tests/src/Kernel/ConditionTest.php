<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;

/**
 * Condition plugin test.
 *
 * @group DCG
 */
final class ConditionTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['node', 'user', 'qux'];

  /**
   * Test callback.
   */
  public function testCondition(): void {

    $node = Node::create(['type' => 'page']);
    $time = \Drupal::time()->getRequestTime();

    /* @var $condition \Drupal\Core\Condition\ConditionInterface */
    $condition = $this->container
      ->get('plugin.manager.condition')
      ->createInstance('example')
      ->setConfig('age', 50)
      ->setContextValue('node', $node);

    self::assertEquals('Node age: 50 sec', $condition->summary());

    // By default created time is set to request time. So that the node age is
    // equal to zero.
    self::assertTrue($condition->execute());

    $node->setCreatedTime($time - 45);
    self::assertTrue($condition->execute());

    $node->setCreatedTime($time - 55);
    self::assertFalse($condition->execute());

    /* @var $condition \Drupal\Core\Executable\ExecutablePluginBase */
    $condition->setConfig('age', NULL);
    self::assertTrue($condition->execute());

    $condition->setConfig('negate', TRUE);
    self::assertTrue($condition->execute());
  }

}
