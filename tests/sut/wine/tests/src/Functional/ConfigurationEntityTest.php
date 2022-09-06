<?php declare(strict_types = 1);

namespace Drupal\Tests\wine\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\dcg_test\TestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Test configuration entity.
 *
 * @group DCG
 */
final class ConfigurationEntityTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['wine'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $user = $this->drupalCreateUser(['administer example']);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testConfigurationEntity(): void {

    $this->drupalGet('admin/structure/example');
    $this->assertPageTitle('Example configuration');
    $this->assertXpath('//td[@colspan = "4" and text() = "There are no examples yet."]');

    $this->drupalGet('admin/structure/example/add');
    $this->assertPageTitle('Add an example');

    $edit = [
      'label' => 'Test',
      'name' => 'test',
      'status' => TRUE,
      'description' => 'The entity description.',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FormattableMarkup('Created new example %label.', ['%label' => 'Test']));

    $this->assertXpath('//tbody//td[text() = "Test"]/following::td[text() = "test"]/following::td[text() = "Enabled"]/following::td//ul[@class = "dropbutton"]');

    $this->getSession()->getDriver()->click('//ul[@class = "dropbutton"]//a[text() = "Edit"]');

    $this->assertPageTitle('Edit an example');
    $this->assertXpath('//input[@name = "label" and @value = "Test"]');
    $this->assertXpath('//input[@name = "status" and @checked = "checked"]');
    $this->assertXpath('//textarea[@name = "description" and text() = "The entity description."]');

    $edit = [
      'label' => 'Updated test',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FormattableMarkup('Updated example %label.', ['%label' => 'Updated test']));

    $this->getSession()->getDriver()->click('//ul[@class = "dropbutton"]//a[text() = "Delete"]');
    $this->assertPageTitle(new FormattableMarkup('Are you sure you want to delete the example %label?', ['%label' => 'Updated test']));

    $this->submitForm([], 'Delete');
    $this->assertStatusMessage(new FormattableMarkup('The example %label has been deleted.', ['%label' => 'Updated test']));
    $this->assertXpath('//td[@colspan = "4" and text() = "There are no examples yet."]');
  }

}
