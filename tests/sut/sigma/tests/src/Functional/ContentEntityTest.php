<?php

declare(strict_types=1);

namespace Drupal\Tests\sigma\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\dcg_test\TestTrait;
use Drupal\sigma\Entity\Example;
use Drupal\Tests\BrowserTestBase;

/**
 * Test example entity type.
 *
 * @group DCG
 */
final class ContentEntityTest extends BrowserTestBase {

  use TestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['sigma', 'field_ui'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testEntityType(): void {
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
    $this->submitForm([], 'Save');
    $this->assertStatusMessage('The configuration has been updated.');

    // -- Add a new field to make sure the entity type is truly fieldable.
    $this->drupalGet('admin/structure/example/fields/add-field');
    $edit = [
      'new_storage_type' => 'plain_text',
    ];
    $this->submitForm($edit, 'Continue');
    $edit = [
      'label' => 'Foo',
      'field_name' => 'foo',
      'group_field_options_wrapper' => 'string',
    ];
    $this->submitForm($edit, 'Continue');
    $this->submitForm([], 'Save settings');

    $this->assertStatusMessage(new FM('Saved %label configuration.', ['%label' => 'Foo']));

    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    $entity_type = $this->container->get('entity_type.manager')->getDefinition('example');

    // -- Test bundle properties.
    self::assertSame('example', $entity_type->getBaseTable());
    self::assertSame('Drupal\sigma\Entity\Example', $entity_type->getClass());
    self::assertSame('Drupal\Core\Entity\EntityAccessControlHandler', $entity_type->getAccessControlClass());
    self::assertSame('administer example', $entity_type->getAdminPermission());
    self::assertNull($entity_type->getBundleEntityType());
    self::assertSame('Example bundle', $entity_type->getBundleLabel());
    self::assertNull($entity_type->getDataTable());

    $handlers = [
      'list_builder' => 'Drupal\sigma\ExampleListBuilder',
      'views_data' => 'Drupal\views\EntityViewsData',
      'form' => [
        'add' => 'Drupal\sigma\Form\ExampleForm',
        'edit' => 'Drupal\sigma\Form\ExampleForm',
        'delete' => 'Drupal\Core\Entity\ContentEntityDeleteForm',
        'delete-multiple-confirm' => 'Drupal\Core\Entity\Form\DeleteMultipleForm',
      ],
      'route_provider' => [
        'html' => 'Drupal\Core\Entity\Routing\AdminHtmlRouteProvider',
      ],
      'access' => 'Drupal\Core\Entity\EntityAccessControlHandler',
      'storage' => 'Drupal\Core\Entity\Sql\SqlContentEntityStorage',
      'view_builder' => 'Drupal\Core\Entity\EntityViewBuilder',
    ];

    self::assertSame($handlers, $entity_type->getHandlerClasses());
    self::assertFalse($entity_type->isRevisionable());
    self::assertFalse($entity_type->isTranslatable());

    $link_templates = [
      'collection' => '/admin/content/example',
      'add-form' => '/example/add',
      'canonical' => '/example/{example}',
      'edit-form' => '/example/{example}/edit',
      'delete-form' => '/example/{example}/delete',
      'delete-multiple-form' => '/admin/content/example/delete-multiple',
    ];
    self::assertSame($link_templates, $entity_type->getLinkTemplates());

    $keys = [
      'id' => 'id',
      'label' => 'label',
      'uuid' => 'uuid',
      'revision' => '',
      'bundle' => '',
      'langcode' => '',
      'default_langcode' => 'default_langcode',
      'revision_translation_affected' => 'revision_translation_affected',
    ];
    self::assertSame($keys, $entity_type->getKeys());

    // -- Create a new entity.
    $this->drupalGet('/example/add');
    $this->assertPageTitle('Add example');

    $edit = [
      'label[0][value]' => 'Beer',
      'field_foo[0][value]' => 'Dark',
    ];
    $this->submitForm($edit, 'Save');

    // -- Test entity view builder.
    $this->assertStatusMessage(new FM('New example %label has been created.', ['%label' => 'Beer']));
    $this->assertPageTitle('Beer');
    $this->assertXpath('//div[text() = "Foo"]/following-sibling::div[text() = "Dark"]');

    // -- Test entity form.
    $this->drupalGet('/example/1/edit');

    $this->assertXpath('//label[text() = "Label"]/following-sibling::input[@name = "label[0][value]" and @value = "Beer"]');
    $this->assertXpath('//label[text() = "Foo"]/following-sibling::input[@name = "field_foo[0][value]" and @value = "Dark"]');

    // -- Test entity values.
    $entity = Example::load(1);
    self::assertSame('1', $entity->id());
    self::assertSame('Beer', $entity->label());
    \drupal_flush_all_caches();
    self::assertSame('Dark', $entity->get('field_foo')->getString());

    $edit = [
      'label[0][value]' => 'Wine',
      'field_foo[0][value]' => 'White',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FM('The example %label has been updated.', ['%label' => 'Wine']));
    $this->assertPageTitle('Wine');

    // -- Test entity list builder.
    $this->drupalGet('/admin/content/example');
    $this->assertPageTitle('Examples');

    $xpath = '//table/thead/tr[1]';
    $xpath .= '//th[text() = "ID"]';
    $xpath .= '/next::th[text() = "Label"]';
    $xpath .= '/next::th[text() = "Operations"]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[1]';
    $xpath .= '//td[text() = "1"]';
    $xpath .= '/next::td[a[text() = "Wine"]]';
    $this->assertXpath($xpath);

    // -- Test entity deletion.
    $this->getSession()->getDriver()->click('//td[text() = "1"]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(new FM('Are you sure you want to delete the example %label?', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('This action cannot be undone');

    $this->submitForm([], 'Delete');
    $this->assertStatusMessage(new FM('The example %label has been deleted.', ['%label' => 'Wine']));
    $this->assertSession()->pageTextContains('There are no examples yet.');
  }

}
