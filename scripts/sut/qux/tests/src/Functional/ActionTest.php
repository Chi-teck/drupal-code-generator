<?php

namespace Drupal\Tests\qux\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Action plugin test.
 *
 * @group DCG
 */
class ActionTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux', 'node', 'action', 'views'];

  /**
   * Test callback.
   */
  public function testContentPage() {
    $this->createContentType(['type' => 'article']);
    $this->createNode(['type' => 'article']);

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
    $this->assertSession()->responseContains('The action has been successfully saved.');

    $this->drupalGet('admin/config/system/actions/configure/update_node_title');
    $this->assertSession()->elementExists('xpath', '//input[@name = "label" and @value = "Update node title"]');
    $this->assertSession()->elementExists('xpath', '//input[@name = "title" and @value = "Example"]');

    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->drupalPostForm('admin/content', $edit, 'Apply to selected items');
    $this->assertSession()->responseContains(t('No access to execute %action_label', ['%action_label' => 'Update node title']));

    // Create another user with permission to edit articles.
    $content_manager = $this->drupalCreateUser(['access content overview', 'edit any article content']);
    $this->drupalLogin($content_manager);
    $edit = [
      'action' => 'update_node_title',
      'node_bulk_form[0]' => TRUE,
    ];
    $this->drupalPostForm('admin/content', $edit, 'Apply to selected items');
    $this->assertSession()->responseContains(t('%action_label was applied to 1 item.', ['%action_label' => 'Update node title']));
    $this->assertSession()->elementExists('xpath', '//table//td[@class = "views-field views-field-title"]/a[text() = "Example"]');
  }

}
