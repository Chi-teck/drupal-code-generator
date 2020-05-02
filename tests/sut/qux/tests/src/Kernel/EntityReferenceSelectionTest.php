<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Form\FormState;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Test for EntityReferenceSelection plugin.
 *
 * @group DCG
 */
final class EntityReferenceSelectionTest extends KernelTestBase {

  use NodeCreationTrait;
  use ContentTypeCreationTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
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

    // Create a node type.
    $content_type = $this->createContentType(['type' => 'page']);

    $field_storage = FieldStorageConfig::create([
      'field_name' => 'field_example',
      'entity_type' => 'node',
      'type' => 'text',
    ]);
    $field_storage->save();

    FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => $content_type->id(),
    ])->save();
  }

  /**
   * Test callback.
   */
  public function testEntityReferenceSelection(): void {

    $node_1 = $this->createNode(['title' => 'Example 1']);
    $node_1->set('field_example', '123');
    $node_1->save();

    $node_1 = $this->createNode(['title' => 'Example 2']);
    $node_1->set('field_example', '456');
    $node_1->save();

    $plugin_manager = \Drupal::service('plugin.manager.entity_reference_selection');

    /** @var \Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface $plugin */
    $plugin = $plugin_manager->createInstance('qux_example', ['target_type' => 'node']);

    // Check default value in configuration form.
    $form = $plugin->buildConfigurationForm([], new FormState());
    self::assertEquals('bar', $form['foo']['#default_value']);

    // Make sure that only first node is referenceable.
    $labels = $plugin->getReferenceableEntities('example')['page'];
    self::assertCount(1, $labels);
    self::assertEquals('Example 1', $labels[1]);
  }

}
