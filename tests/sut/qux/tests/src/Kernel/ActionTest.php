<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;
use Drupal\node\NodeTypeInterface;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * A test for action plugin.
 */
#[Group('DCG')]
final class ActionTest extends KernelTestBase {

  use ContentTypeCreationTrait;
  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'user',
    'system',
    'filter',
    'field',
    'text',
    'qux',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installSchema('node', 'node_access');
    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installConfig('filter');
    $this->installConfig('node');

    $content_type = $this->createContentType(['type' => 'article']);
    self::addExampleField($content_type);
  }

  /**
   * Test callback.
   */
  public function testAction(): void {
    /** @var \Drupal\Core\Action\ActionInterface $action */
    $action = $this->container
      ->get('plugin.manager.action')
      ->createInstance('qux_update_node_field');

    // Check plugin definition.
    self::assertEquals('qux_update_node_field', $action->getPluginId());
    self::assertEquals('Update node field', $action->getPluginDefinition()['label']);
    self::assertEquals('DCG', $action->getPluginDefinition()['category']);
    self::assertEquals('node', $action->getPluginDefinition()['type']);

    $node = $this->createNode(['type' => 'article']);
    self::assertInstanceOf(AccessResultInterface::class, $action->access($node, return_as_object: TRUE));

    $action->execute($node);
    $field_example_value = $node->get('field_example')->first()?->get('value')->getValue();
    self::assertEquals('New value', $field_example_value);
  }

  /**
   * Adds 'field_example' field to a content type.
   */
  private static function addExampleField(NodeTypeInterface $type): void {
    $field_storage = FieldStorageConfig::create([
      'field_name' => 'field_example',
      'entity_type' => 'node',
      'type' => 'string',
    ]);
    $field_storage->save();

    FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => $type->id(),
      'label' => 'Example',
    ])->save();
  }

}
