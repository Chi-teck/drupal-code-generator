<?php

namespace Drupal\Tests\qux\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Tests\BrowserTestBase;
use Drupal\dcg_test\TestTrait;

/**
 * Action plugin test.
 *
 * @group DCG
 */
class ActionTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'node', 'action', 'views'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testAction() {

    $this->createContentType(['type' => 'article']);
    $node = $this->createNode(['type' => 'article']);

    $user = $this->drupalCreateUser(['access content overview', 'administer actions']);
    $this->drupalLogin($user);

    $edit = [
      'action' => 'qux_update_node_title',
    ];
    $this->drupalPostForm('admin/config/system/actions', $edit, 'Create');

    $edit = [
      'id' => 'update_node_title',
      'title' => 'Example',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertStatusMessage('The action has been successfully saved.');

    $this->drupalGet('admin/config/system/actions/configure/update_node_title');
    $this->assertXpath('//input[@name = "label" and @value = "Update node title"]');
    $this->assertXpath('//input[@name = "title" and @value = "Example"]');

    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->drupalPostForm('admin/content', $edit, 'Apply to selected items');
    $message_arguments = [
      '%action_label' => 'Update node title',
      '%node_label' => $node->label(),
    ];
    $this->assertErrorMessage(new FormattableMarkup('No access to execute %action_label on the Content %node_label.', $message_arguments));

    // Create another user with permission to edit articles.
    $content_manager = $this->drupalCreateUser(['access content overview', 'edit any article content']);
    $this->drupalLogin($content_manager);
    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->drupalPostForm('admin/content', $edit, 'Apply to selected items');
    $message_arguments = [
      '%action_label' => 'Update node title',
    ];
    $this->assertStatusMessage(new FormattableMarkup('%action_label was applied to 1 item.', $message_arguments));
    $this->assertXpath('//table//td[@class = "views-field views-field-title"]/a[text() = "Example"]');
  }

}
