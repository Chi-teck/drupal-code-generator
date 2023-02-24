<?php declare(strict_types = 1);

namespace Drupal\Tests\qux\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Tests the field plugins.
 *
 * @group DCG
 */
abstract class FieldBaseTest extends WebDriverTestBase {

  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'claro';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux', 'node', 'field_ui'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->createContentType(['type' => 'test']);

    $permissions = [
      'administer node fields',
      'administer node form display',
      'administer node display',
      'create test content',
      'edit own test content',
    ];
    $user = $this->createUser($permissions);
    $this->drupalLogin($user);

    // Create text field.
    $this->drupalGet('admin/structure/types/manage/test/fields/add-field');
    $page = $this->getSession()->getPage();
    $page->selectFieldOption('new_storage_type', 'string');
    $page->fillField('label', 'Wine');
    $this->assertSession()->waitForElementVisible('css', '#edit-label-machine-name-suffix');
    $page->pressButton('Save and continue');
  }

  /**
   * Waits for Ajax request to be finished.
   */
  protected function waitForAjax(): void {
    $page = $this->getSession()->getPage();
    $page->waitFor(10, static function () use ($page): bool {
      $element = $page->find('css', '.throbber');
      return $element === NULL || \count($element) === 0;
    });
  }

}
