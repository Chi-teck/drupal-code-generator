<?php

namespace Drupal\Tests\wine\Functional;

use TestBase\BrowserTestBase;

/**
 * Test configuration entity.
 *
 * @group DCG
 */
class ConfigurationEntityTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['wine'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $user = $this->drupalCreateUser(['administer example']);
    $this->drupalLogin($user);
  }

  /**
   * Test callback.
   */
  public function testConfigurationEntity() {

    $this->drupalGet('admin/structure/example');
    $this->assertPageTitle('Example configuration');
    $this->assertXpath('//td[@class = "empty message" and text() = "There are no examples yet."]');

    $this->drupalGet('admin/structure/example/add');
    $this->assertPageTitle('Add an example');

    $edit = [
      'label' => 'Test',
      'name' => 'test',
      'status' => TRUE,
      'description' => 'The entity description.',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertStatusMessage(t('Created new example %label.', ['%label' => 'Test']));

    $this->assertXpath('//tbody//td[text() = "Test"]/following::td[text() = "test"]/following::td[text() = "Enabled"]/following::td//ul[@class = "dropbutton"]');

    $this->click('//ul[@class = "dropbutton"]//a[text() = "Edit"]');

    $this->assertPageTitle('Edit an example');
    $this->assertXpath('//input[@name = "label" and @value = "Test"]');
    $this->assertXpath('//input[@name = "status" and @checked = "checked"]');
    $this->assertXpath('//textarea[@name = "description" and text() = "The entity description."]');

    $edit = [
      'label' => 'Updated test',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertStatusMessage(t('Updated example %label.', ['%label' => 'Updated test']));

    $this->click('//ul[@class = "dropbutton"]//a[text() = "Delete"]');
    $this->assertPageTitle(t('Are you sure you want to delete the example %label?', ['%label' => 'Updated test']));

    $this->drupalPostForm(NULL, [], 'Delete');
    $this->assertStatusMessage(t('The example %label has been deleted.', ['%label' => 'Updated test']));
    $this->assertXpath('//td[@class = "empty message" and text() = "There are no examples yet."]');
  }

}
