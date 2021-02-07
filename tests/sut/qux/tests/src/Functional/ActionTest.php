<?php

namespace Drupal\Tests\qux\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\dcg_test\TestTrait;
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

    $this->createContentType(['type' => 'article']);
    $node = $this->createNode(['type' => 'article']);

    $permissions = ['access content overview', 'administer actions'];
    $user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($user);

    $this->drupalGet('admin/config/system/actions');
    $edit = [
      'action' => 'qux_update_node_title',
    ];
    $this->submitForm($edit, 'Create');

    $edit = [
      'id' => 'update_node_title',
      'title' => 'Example',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage('The action has been successfully saved.');

    $this->drupalGet('admin/config/system/actions/configure/update_node_title');
    $this->assertXpath('//input[@name = "label" and @value = "Update node title"]');
    $this->assertXpath('//input[@name = "title" and @value = "Example"]');

    $this->drupalGet('admin/content');
    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->submitForm($edit, 'Apply to selected items');
    $message_arguments = [
      '%action_label' => 'Update node title',
      '%node_label' => $node->label(),
    ];
    $this->assertErrorMessage(new FM('No access to execute %action_label on the Content %node_label.', $message_arguments));

    // Create another user with permission to edit articles.
    $permissions = ['access content overview', 'edit any article content'];
    $content_manager = $this->drupalCreateUser($permissions);
    $this->drupalLogin($content_manager);
    $this->drupalGet('admin/content');
    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->submitForm($edit, 'Apply to selected items');
    $message_arguments = [
      '%action_label' => 'Update node title',
    ];
    $this->assertStatusMessage(new FM('%action_label was applied to 1 item.', $message_arguments));
    $this->assertXpath('//table//td[@class = "views-field views-field-title"]/a[text() = "Example"]');
  }

}
