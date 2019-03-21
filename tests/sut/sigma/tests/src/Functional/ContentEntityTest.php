<?php

namespace Drupal\Tests\sigma\Functional;

use Drupal\sigma\Entity\Example;
use TestBase\BrowserTestBase;

/**
 * Test example entity type.
 *
 * @group DCG
 */
class ContentEntityTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['sigma', 'field_ui'];

  /**
   * Test callback.
   */
  public function testEntityTypeUi() {

    $permissions = [
      'administer example',
      'administer example fields',
    ];
    $admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($admin_user);

    // -- Test settings form.
    $this->drupalGet('admin/structure/example');
    $this->assertPageTitle('Example');
    $this->assertSession()->pageTextContains('Settings form for an example entity type.');
    $this->drupalPostForm(NULL, [], 'Save');
    $this->assertStatusMessage('The configuration has been updated.');

    // -- Add a new field to make sure the entity type is truly fieldable.
    $edit = [
      'new_storage_type' => 'string',
      'label' => 'Foo',
      'field_name' => 'foo',
    ];

    $this->drupalPostForm('admin/structure/example/fields/add-field', $edit, 'Save');
    $this->drupalPostForm(NULL, [], 'Save field settings');
    $this->drupalPostForm(NULL, [], 'Save settings');
    $this->assertStatusMessage(t('Saved %label configuration.', ['%label' => 'Foo']));

    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    $entity_type = \Drupal::entityTypeManager()->getDefinition('example');

    // -- Test bundle properties.
    self::assertEquals('example', $entity_type->getBaseTable());
    self::assertEquals('Drupal\sigma\Entity\Example', $entity_type->getClass());
    self::assertEquals('Drupal\Core\Entity\EntityAccessControlHandler', $entity_type->getAccessControlClass());
    self::assertEquals('administer example', $entity_type->getAdminPermission());
    self::assertNull($entity_type->getBundleEntityType());
    self::assertEquals('Example bundle', $entity_type->getBundleLabel());
    self::assertNull($entity_type->getDataTable());

    $handlers = [
      'view_builder' => 'Drupal\sigma\ExampleViewBuilder',
      'list_builder' => 'Drupal\sigma\ExampleListBuilder',
      'views_data' => 'Drupal\views\EntityViewsData',
      'access' => 'Drupal\Core\Entity\EntityAccessControlHandler',
      'form' => [
        'add' => 'Drupal\sigma\Form\ExampleForm',
        'edit' => 'Drupal\sigma\Form\ExampleForm',
        'delete' => 'Drupal\Core\Entity\ContentEntityDeleteForm',
      ],
      'route_provider' => [
        'html' => 'Drupal\Core\Entity\Routing\AdminHtmlRouteProvider',
      ],
      'storage' => 'Drupal\Core\Entity\Sql\SqlContentEntityStorage',
    ];

    self::assertEquals($handlers, $entity_type->getHandlerClasses());
    self::assertFalse($entity_type->isRevisionable());
    self::assertFalse($entity_type->isTranslatable());

    $link_templates = [
      'add-form' => '/example/add',
      'canonical' => '/example/{example}',
      'edit-form' => '/example/{example}/edit',
      'delete-form' => '/example/{example}/delete',
      'collection' => '/admin/content/example',
    ];
    self::assertEquals($link_templates, $entity_type->getLinkTemplates());

    $keys = [
      'id' => 'id',
      'revision' => '',
      'langcode' => '',
      'bundle' => '',
      'label' => 'title',
      'uuid' => 'uuid',
      'default_langcode' => 'default_langcode',
      'revision_translation_affected' => 'revision_translation_affected',
    ];
    self::assertEquals($keys, $entity_type->getKeys());

    // -- Create a new entity.
    $this->drupalGet('/example/add');
    $this->assertPageTitle('Add example');

    $edit = [
      'title[0][value]' => 'Beer',
      'field_foo[0][value]' => 'Dark',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');

    // -- Test entity view builder.
    $this->assertStatusMessage(t('New example %label has been created.', ['%label' => 'Beer']));
    $this->assertPageTitle('Beer');
    $this->assertXpath('//div[text() = "Foo"]/following-sibling::div[text() = "Dark"]');

    // -- Test entity form.
    $this->drupalGet('/example/1/edit');

    $this->assertXpath('//label[text() = "Title"]/following-sibling::input[@name = "title[0][value]" and @value = "Beer"]');
    $this->assertXpath('//label[text() = "Foo"]/following-sibling::input[@name = "field_foo[0][value]" and @value = "Dark"]');

    // -- Test entity values.
    $entity = Example::load(1);
    self::assertEquals(1, $entity->id());
    self::assertEquals('Beer', $entity->getTitle());
    drupal_flush_all_caches();
    self::assertEquals('Dark', $entity->get('field_foo')->getString());

    $edit = [
      'title[0][value]' => 'Wine',
      'field_foo[0][value]' => 'White',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertStatusMessage(t('The example %label has been updated.', ['%label' => 'Wine']));
    $this->assertPageTitle('Wine');

    // -- Test entity list builder.
    $this->drupalGet('/admin/content/example');
    $this->assertPageTitle('Examples');

    $xpath = '//table/thead/tr[1]';
    $xpath .= '//th[text() = "ID"]';
    $xpath .= '/next::th[text() = "Title"]';
    $xpath .= '/next::th[text() = "Operations"]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[1]';
    $xpath .= '//td[text() = "1"]';
    $xpath .= '/next::td[a[text() = "Wine"]]';
    $this->assertXpath($xpath);

    $this->assertSession()->pageTextContains('Total examples: 1');

    // -- Test entity deletion.
    $this->click('//td[text() = "1"]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(t('Are you sure you want to delete the example %label?', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('This action cannot be undone');

    $this->drupalPostForm(NULL, [], 'Delete');
    $this->assertStatusMessage(t('The example %label has been deleted.', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('There are no example entities yet.');
    $this->assertSession()->pageTextContains('Total examples: 0');
  }

}
