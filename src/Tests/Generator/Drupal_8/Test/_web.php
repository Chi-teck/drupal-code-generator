<?php

namespace Drupal\foo\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the site configuration.
 *
 * @group foo
 */
class ExampleTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'node',
    'field',
    'contact',
    'views',
    'taxonomy',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $user = $this->drupalCreateUser([
      'administer site configuration',
    ]);
    $this->drupalLogin($user);
  }

  /**
   * Test site information form.
   */
  public function testFieldStorageSettingsForm() {
    $edit = [
      'site_name' => 'Drupal',
      'site_slogan' => 'Community plumbing',
      'site_mail' => 'admin@example.local',
      'site_frontpage' => '/user',
    ];

    $this->drupalPostForm('admin/config/system/site-information', $edit, t('Save configuration'));
    $this->assertText(t('The configuration options have been saved.'), 'Configuration options have been saved');
  }

}
