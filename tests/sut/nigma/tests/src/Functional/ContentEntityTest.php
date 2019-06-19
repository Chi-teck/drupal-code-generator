<?php

namespace Drupal\Tests\nigma\Functional;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\nigma\Entity\Example;
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
  public static $modules = ['nigma', 'field_ui', 'text'];

  /**
   * Test callback.
   */
  public function testEntityTypeUi() {

    $permissions = [
      'administer example types',
      'administer example fields',
      'view example',
      'create example',
      'edit example',
      'delete example',
    ];
    $admin_user = $this->drupalCreateUser($permissions, 'example_admin');
    $this->drupalLogin($admin_user);

    // -- Create a new bundle.
    $this->drupalGet('admin/structure/example_types');
    $this->assertPageTitle('Example type entities');
    $this->assertXpath('//td[@class = "empty message" and contains(text(), "No example types available.")]');

    $this->clickLink('Add example type');
    $this->assertPageTitle('Add example type');

    $edit = [
      'label' => 'Foo',
      'id' => 'foo',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save example type');
    $this->assertStatusMessage(new FormattableMarkup('The example type %label has been added.', ['%label' => 'Foo']));

    $this->click('//td[text() = "Foo"]/following-sibling::td//a[text() = "Edit"]');
    $this->assertPageTitle(new FormattableMarkup('Edit %label example type', ['%label' => 'Foo']));
    $this->assertXpath('//label[text() = "Label"]/following-sibling::input[@name = "label" and @value="Foo"]');

    $edit = [
      'label' => 'Bar',
      'id' => 'bar',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save example type');
    $this->assertStatusMessage(new FormattableMarkup('The example type %label has been updated.', ['%label' => 'Bar']));

    // Make sure the entity type is fieldable.
    $this->click('//td[text() = "Bar"]/following-sibling::td//a[text() = "Manage fields"]');
    $this->assertPageTitle('Manage fields');

    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    $entity_type = \Drupal::entityTypeManager()->getDefinition('example');

    // -- Test bundle properties.
    self::assertEquals('example', $entity_type->getBaseTable());
    self::assertEquals('Drupal\nigma\Entity\Example', $entity_type->getClass());
    self::assertEquals('Drupal\nigma\ExampleAccessControlHandler', $entity_type->getAccessControlClass());
    self::assertEquals('administer example types', $entity_type->getAdminPermission());
    self::assertEquals('example_type', $entity_type->getBundleEntityType());
    self::assertEquals('Example type', $entity_type->getBundleLabel());
    self::assertEquals('example_field_data', $entity_type->getDataTable());

    $handlers = [
      'view_builder' => 'Drupal\Core\Entity\EntityViewBuilder',
      'list_builder' => 'Drupal\nigma\ExampleListBuilder',
      'views_data' => 'Drupal\views\EntityViewsData',
      'access' => 'Drupal\nigma\ExampleAccessControlHandler',
      'form' => [
        'add' => 'Drupal\nigma\Form\ExampleForm',
        'edit' => 'Drupal\nigma\Form\ExampleForm',
        'delete' => 'Drupal\Core\Entity\ContentEntityDeleteForm',
      ],
      'route_provider' => [
        'html' => 'Drupal\Core\Entity\Routing\AdminHtmlRouteProvider',
      ],
      'storage' => 'Drupal\Core\Entity\Sql\SqlContentEntityStorage',
    ];

    self::assertEquals($handlers, $entity_type->getHandlerClasses());
    self::assertTrue($entity_type->isRevisionable());
    self::assertTrue($entity_type->isTranslatable());

    $link_templates = [
      'add-form' => '/admin/content/example/add/{example_type}',
      'add-page' => '/admin/content/example/add',
      'canonical' => '/example/{example}',
      'edit-form' => '/admin/content/example/{example}/edit',
      'delete-form' => '/admin/content/example/{example}/delete',
      'collection' => '/admin/content/example',
    ];
    self::assertEquals($link_templates, $entity_type->getLinkTemplates());

    $keys = [
      'id' => 'id',
      'revision' => 'revision_id',
      'langcode' => 'langcode',
      'bundle' => 'bundle',
      'label' => 'title',
      'uuid' => 'uuid',
      'default_langcode' => 'default_langcode',
      'revision_translation_affected' => 'revision_translation_affected',
    ];
    self::assertEquals($keys, $entity_type->getKeys());

    // -- Create a new entity.
    $this->drupalGet('/admin/content/example/add');
    $this->assertPageTitle('Add example');

    $edit = [
      'title[0][value]' => 'Beer',
      'description[0][value]' => 'Dark',
      'revision_log[0][value]' => 'New revision',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');

    // -- Test entity view builder.
    $this->assertStatusMessage(new FormattableMarkup('New example %label has been created.', ['%label' => 'Beer']));
    $this->assertPageTitle('Beer');
    $this->assertXpath('//div[text() = "Status"]/following-sibling::div[text() = "Enabled"]');
    $this->assertXpath('//div[text() = "Description"]/following-sibling::div/p[text() = "Dark"]');
    $this->assertXpath('//div[text() = "Author"]/following-sibling::div/a[text() = "example_admin"]');
    $this->assertXpath('//div[text() = "Authored on"]/following-sibling::div[@class = "field__item"]');

    // -- Test entity form.
    $this->drupalGet('/admin/content/example/1/edit');

    $this->assertXpath('//label[text() = "Title"]/following-sibling::input[@name = "title[0][value]" and @value = "Beer"]');
    $this->assertXpath('//input[@name = "status[value]" and @value="1"]/following-sibling::label[text() = "Enabled"]');
    $this->assertXpath('//label[text() = "Description"]/following-sibling::div/textarea[@name = "description[0][value]"]');
    $this->assertXpath('//label[text() = "Author"]/following-sibling::input[@name = "uid[0][target_id]"]');
    $this->assertXpath('//label[text() = "Date"]/following-sibling::input[@name = "created[0][value][date]"]');
    $this->assertXpath('//label[text() = "Time"]/following-sibling::input[@name = "created[0][value][time]"]');
    $this->assertXpath('//label[text() = "Revision log message"]/following-sibling::div/textarea[@name = "revision_log[0][value]"]');

    // -- Test entity values.
    $entity = Example::load(1);
    self::assertEquals(1, $entity->id());
    self::assertEquals('Beer', $entity->getTitle());
    self::assertEquals('foo', $entity->bundle());
    self::assertEquals('Dark, plain_text', $entity->get('description')->getString());
    self::assertEquals('New revision', $entity->getRevisionLogMessage());

    $edit = [
      'title[0][value]' => 'Wine',
      'description[0][value]' => 'White',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save');
    $this->assertStatusMessage(new FormattableMarkup('The example %label has been updated.', ['%label' => 'Wine']));
    $this->assertPageTitle('Wine');

    // -- Test entity list builder.
    $this->drupalGet('/admin/content/example');
    $this->assertPageTitle('Examples');

    $xpath = '//table/thead/tr[1]';
    $xpath .= '//th[text() = "ID"]';
    $xpath .= '/next::th[text() = "Title"]';
    $xpath .= '/next::th[text() = "Status"]';
    $xpath .= '/next::th[text() = "Author"]';
    $xpath .= '/next::th[text() = "Created"]';
    $xpath .= '/next::th[text() = "Updated"]';
    $xpath .= '/next::th[text() = "Operations"]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[1]';
    $xpath .= '//td[text() = "1"]';
    $xpath .= '/next::td[a[text() = "Wine"]]';
    $xpath .= '/next::td[text() = "Enabled"]';
    $xpath .= '/next::td[a[text() = "example_admin"]]';
    $this->assertXpath($xpath);

    $this->assertSession()->pageTextContains('Total examples: 1');

    // -- Test entity deletion.
    $this->click('//td[text() = "1"]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(new FormattableMarkup('Are you sure you want to delete the example %label?', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('This action cannot be undone');

    $this->drupalPostForm(NULL, [], 'Delete');
    $this->assertStatusMessage(new FormattableMarkup('The example %label has been deleted.', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('There are no example entities yet.');
    $this->assertSession()->pageTextContains('Total examples: 0');
  }

}
