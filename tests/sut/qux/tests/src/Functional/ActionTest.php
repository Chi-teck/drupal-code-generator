<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\dcg_test\TestTrait;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\NodeTypeInterface;
use Drupal\Tests\BrowserTestBase;

/**
 * Action plugin test.
 *
 * @group DCG
 */
final class ActionTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'node', 'action', 'views'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testAction(): void {

    $content_type = $this->createContentType(['type' => 'article']);
    self::addExampleField($content_type);
    $node = $this->createNode(['type' => 'article']);

    $this->drupalLogin(
      $this->drupalCreateUser(['access content overview', 'administer actions']),
    );

    // -- Create an action.
    $this->drupalGet('admin/config/system/actions');
    $edit = [
      'action' => 'qux_update_node_field',
    ];
    $this->submitForm($edit, 'Create');

    $edit = [
      'id' => 'update_node_field',
      'example' => 'Yay',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage('The action has been successfully saved.');
    $this->drupalGet('admin/config/system/actions/configure/update_node_field');
    $this->assertXpath('//input[@name = "label" and @value = "Update node field"]');
    $this->assertXpath('//input[@name = "example" and @value = "Yay"]');

    // -- Apply the action.
    $this->drupalGet('admin/content');
    $edit = [
      'action' => 'update_node_field',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->submitForm($edit, 'Apply to selected items');
    $this->assertErrorMessage(
      new FM(
        'No access to execute %action_label on the Content %node_label.',
        [
          '%action_label' => 'Update node field',
          '%node_label' => $node->label(),
        ],
      ),
    );

    // Create another user with permission to edit articles.
    $permissions = ['access content overview', 'edit any article content'];
    $this->drupalLogin($this->drupalCreateUser($permissions));
    $this->drupalGet('admin/content');
    $this->submitForm($edit, 'Apply to selected items');
    $this->assertStatusMessage(
      new FM('%action_label was applied to 1 item.',
        ['%action_label' => 'Update node field'],
      ),
    );
    $this->drupalGet($node->toUrl());
    $this->assertXpath('//article//div[text() = "Example"]/following-sibling::div[text() = "New value"]');
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

    EntityViewDisplay::load('node.' . $type->id() . '.default')
      ->setComponent('field_example', ['label' => 'Example'])
      ->save();
  }

}
