<?php declare(strict_types = 1);

namespace Drupal\Tests\nigma\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\nigma\Entity\Example;
use Drupal\Tests\user\Traits\UserCreationTrait;

/**
 * Tests access handler for example entity type.
 *
 * @group nigma
 */
final class AccessHandlerTest extends KernelTestBase {

  use UserCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'filter', 'text', 'user', 'nigma'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('user');
    // Create a user to ensure that subsequently created users will not get
    // UID = 1.
    $this->createUser();
  }

  /**
   * Test callback.
   *
   * @dataProvider testAccessHandlerProvider().
   */
  public function testAccessHandler(array $permissions, array $expected_access): void {
    $account = $this->createUser($permissions);
    $entity = Example::create(['bundle' => 'example']);
    foreach (['create', 'view', 'update', 'delete'] as $operation) {
      self::assertSame(
        \in_array($operation, $expected_access),
        $entity->access($operation, $account),
      );
    }
  }

  /**
   * Data provider callback.
   */
  public function testAccessHandlerProvider(): array {
    $data[] = [
      ['view example'],
      ['view'],
    ];
    $data[] = [
      ['edit example'],
      ['update'],
    ];
    $data[] = [
      ['delete example'],
      ['delete'],
    ];
    $data[] = [
      ['create example'],
      ['create'],
    ];
    $data[] = [
      ['administer example types'],
      ['view', 'update', 'delete', 'create'],
    ];
    return $data;
  }

}
