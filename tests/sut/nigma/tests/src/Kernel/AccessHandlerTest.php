<?php

declare(strict_types=1);

namespace Drupal\Tests\nigma\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\user\Traits\UserCreationTrait;
use Drupal\nigma\Entity\Example;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests access handler for example entity type.
 */
#[Group('nigma')]
final class AccessHandlerTest extends KernelTestBase {

  use UserCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'filter', 'text', 'user', 'nigma'];

  private Example $entity;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('user');
    $this->installEntitySchema('example');
    // Create a user to ensure that subsequently created users will not get
    // UID = 1.
    $this->createUser();

    $entity_type_manager = $this->container->get('entity_type.manager');

    $example_type_storage = $entity_type_manager->getStorage('example_type');
    $example_type_entity = $example_type_storage->create([
      'label' => 'Foo',
      'id' => 'foo',
    ]);
    $example_type_storage->save($example_type_entity);

    $example_storage = $entity_type_manager->getStorage('example');
    $example_entity = $example_storage->create([
      'label' => 'Example',
      'bundle' => 'foo',
    ]);

    $example_storage->save($example_entity);
    // Mark as non-default revision for testing revert operations and delete
    // revision.
    $example_entity->isDefaultRevision(FALSE);
    $this->entity = $example_entity;
  }

  /**
   * Test callback.
   */
  #[DataProvider('testAccessHandlerProvider')]
  public function testAccessHandler(array $permissions, array $expected_access): void {
    $account = $this->createUser($permissions);

    $operations = [
      'create',
      'view',
      'update',
      'delete',
      'view all revisions',
      'view revision',
      'revert',
      'delete revision',
    ];

    foreach ($operations as $operation) {
      self::assertSame(
        \in_array($operation, $expected_access),
        $this->entity->access($operation, $account),
      );
    }
  }

  /**
   * Data provider callback.
   */
  public static function testAccessHandlerProvider(): array {
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
      ['view example', 'view example revision'],
      ['view', 'view all revisions', 'view revision'],
    ];
    $data[] = [
      ['edit example', 'revert example revision'],
      ['update', 'revert'],
    ];
    $data[] = [
      ['delete example revision'],
      ['delete revision'],
    ];
    $data[] = [
      ['administer example types'],
      [
        'view',
        'update',
        'delete',
        'create',
        'view all revisions',
        'view revision',
        'revert',
        'delete revision',
      ],
    ];
    return $data;
  }

}
