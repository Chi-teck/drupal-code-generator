<?php

declare(strict_types=1);

namespace Drupal\Tests\nigma\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\dcg_test\TestTrait;
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
  protected static $modules = ['nigma', 'field_ui', 'text'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test callback.
   */
  public function testEntityType(): void {

    $permissions = [
      'administer example types',
      'administer example fields',
      'view example',
      'create example',
      'edit example',
      'delete example',
      'view example revision',
      'revert example revision',
      'delete example revision',
    ];
    $admin_user = $this->drupalCreateUser($permissions, 'example_admin');
    $this->drupalLogin($admin_user);

    // -- Create a new bundle.
    $this->drupalGet('admin/structure/example_types');
    $this->assertPageTitle('Example types');
    $this->assertXpath('//td[@colspan = "2" and contains(text(), "No example types available.")]');

    $this->clickLink('Add example type');
    $this->assertPageTitle('Add example type');

    $edit = [
      'label' => 'Foo',
      'id' => 'foo',
    ];
    $this->submitForm($edit, 'Save example type');
    $this->assertStatusMessage(new FM('The example type %label has been added.', ['%label' => 'Foo']));

    $this->getSession()->getDriver()->click('//td[text() = "Foo"]/following-sibling::td//a[text() = "Edit"]');
    $this->assertPageTitle(new FM('Edit %label example type', ['%label' => 'Foo']));
    $this->assertXpath('//label[text() = "Label"]/following-sibling::input[@name = "label" and @value="Foo"]');

    $edit = [
      'label' => 'Bar',
      'id' => 'bar',
    ];
    $this->submitForm($edit, 'Save example type');
    $this->assertStatusMessage(new FM('The example type %label has been updated.', ['%label' => 'Bar']));

    // Make sure the entity type is fieldable.
    $this->getSession()->getDriver()->click('//td[text() = "Bar"]/following-sibling::td//a[text() = "Manage fields"]');
    $this->assertPageTitle('Manage fields');

    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    $entity_type = $this->container->get('entity_type.manager')->getDefinition('example');

    // -- Test bundle properties.
    self::assertSame('example', $entity_type->getBaseTable());
    self::assertSame('Drupal\nigma\Entity\Example', $entity_type->getClass());
    self::assertSame('Drupal\nigma\ExampleAccessControlHandler', $entity_type->getAccessControlClass());
    self::assertSame('administer example types', $entity_type->getAdminPermission());
    self::assertSame('example_type', $entity_type->getBundleEntityType());
    self::assertSame('Example type', $entity_type->getBundleLabel());
    self::assertSame('example_field_data', $entity_type->getDataTable());

    $handlers = [
      'list_builder' => 'Drupal\nigma\ExampleListBuilder',
      'views_data' => 'Drupal\views\EntityViewsData',
      'access' => 'Drupal\nigma\ExampleAccessControlHandler',
      'form' => [
        'add' => 'Drupal\nigma\Form\ExampleForm',
        'edit' => 'Drupal\nigma\Form\ExampleForm',
        'delete' => 'Drupal\Core\Entity\ContentEntityDeleteForm',
        'delete-multiple-confirm' => 'Drupal\Core\Entity\Form\DeleteMultipleForm',
        'revision-delete' => 'Drupal\Core\Entity\Form\RevisionDeleteForm',
        'revision-revert' => 'Drupal\Core\Entity\Form\RevisionRevertForm',
      ],
      'route_provider' => [
        'html' => 'Drupal\Core\Entity\Routing\AdminHtmlRouteProvider',
        'revision' => 'Drupal\Core\Entity\Routing\RevisionHtmlRouteProvider',
      ],
      'storage' => 'Drupal\Core\Entity\Sql\SqlContentEntityStorage',
      'view_builder' => 'Drupal\Core\Entity\EntityViewBuilder',
    ];

    self::assertSame($handlers, $entity_type->getHandlerClasses());
    self::assertTrue($entity_type->isRevisionable());
    self::assertTrue($entity_type->isTranslatable());

    $link_templates = [
      'collection' => '/admin/content/example',
      'add-form' => '/admin/content/example/add/{example_type}',
      'add-page' => '/admin/content/example/add',
      'canonical' => '/admin/content/example/{example}',
      'edit-form' => '/admin/content/example/{example}/edit',
      'delete-form' => '/admin/content/example/{example}/delete',
      'delete-multiple-form' => '/admin/content/example/delete-multiple',
      'revision' => '/admin/content/example/{example}/revision/{example_revision}/view',
      'revision-delete-form' => '/admin/content/example/{example}/revision/{example_revision}/delete',
      'revision-revert-form' => '/admin/content/example/{example}/revision/{example_revision}/revert',
      'version-history' => '/admin/content/example/{example}/revisions',
    ];
    self::assertSame($link_templates, $entity_type->getLinkTemplates());

    $keys = [
      'id' => 'id',
      'revision' => 'revision_id',
      'langcode' => 'langcode',
      'bundle' => 'bundle',
      'label' => 'label',
      'uuid' => 'uuid',
      'owner' => 'uid',
      'default_langcode' => 'default_langcode',
      'revision_translation_affected' => 'revision_translation_affected',
    ];
    self::assertSame($keys, $entity_type->getKeys());

    // -- Try to create a bundle with the same name.
    $this->drupalGet('admin/structure/example_types/add');
    $edit = [
      'label' => 'Foo',
      'id' => 'foo',
    ];
    $this->submitForm($edit, 'Save example type');
    $this->assertErrorMessage('The machine-readable name is already in use. It must be unique.');

    // -- Create a new entity.
    $this->drupalGet('/admin/content/example/add');
    $this->assertPageTitle('Add example');

    $edit = [
      'label[0][value]' => 'Beer',
      'description[0][value]' => 'Dark',
      'revision_log[0][value]' => 'First version',
    ];
    $this->submitForm($edit, 'Save');

    // -- Test entity view builder.
    $this->assertStatusMessage(new FM('New example %label has been created.', ['%label' => 'Beer']));
    $this->assertPageTitle('Beer');
    $this->assertXpath('//div[text() = "Status"]/following-sibling::div[text() = "Enabled"]');
    $this->assertXpath('//div[text() = "Description"]/following-sibling::div/p[text() = "Dark"]');
    $this->assertXpath('//div[text() = "Author"]/following-sibling::div/a[text() = "example_admin"]');
    $this->assertXpath('//div[text() = "Authored on"]/following-sibling::div');

    // -- Test entity form.
    $this->drupalGet('/admin/content/example/1/edit');

    $this->assertXpath('//label[text() = "Label"]/following-sibling::input[@name = "label[0][value]" and @value = "Beer"]');
    $this->assertXpath('//input[@name = "status[value]" and @value="1"]/following-sibling::label[text() = "Enabled"]');
    $this->assertXpath('//label[text() = "Description"]/following-sibling::div/textarea[@name = "description[0][value]"]');
    $this->assertXpath('//label[text() = "Author"]/following-sibling::input[@name = "uid[0][target_id]"]');
    $this->assertXpath('//label[text() = "Date"]/following-sibling::input[@name = "created[0][value][date]"]');
    $this->assertXpath('//label[text() = "Time"]/following-sibling::input[@name = "created[0][value][time]"]');
    $this->assertXpath('//label[text() = "Revision log message"]/following-sibling::div/textarea[@name = "revision_log[0][value]"]');

    // -- Test entity values.
    $example_storage = $this
      ->container
      ->get('entity_type.manager')
      ->getStorage('example');

    $entity = $example_storage->load(1);
    self::assertSame('1', $entity->id());
    self::assertSame('Beer', $entity->label());
    self::assertSame('foo', $entity->bundle());
    self::assertSame('Dark, plain_text', $entity->get('description')->getString());
    self::assertSame('First version', $entity->getRevisionLogMessage());

    $edit = [
      'label[0][value]' => 'Wine',
      'description[0][value]' => 'White',
      'revision' => '1',
      'revision_log[0][value]' => 'Second version',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FM('The example %label has been updated.', ['%label' => 'Wine']));
    $this->assertPageTitle('Wine');

    // -- Test entity revisions list.
    $this->drupalGet('/admin/content/example/1/revisions');
    $this->assertPageTitle('Revisions');

    $xpath = '//table/thead/tr[1]';
    $xpath .= '//th[text() = "Revision"]';
    $xpath .= '/next::th[text() = "Operations"]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[1]';
    $xpath .= '//td[p[text() = "Second version"]]';
    $xpath .= '/next::td[em[text() = "Current revision"]]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[2]';
    $xpath .= '//td[p[text() = "First version"]]';
    $this->assertXpath($xpath);

    // -- Test view revision.
    $date_formatter = $this->container->get('date.formatter');
    $entity_revision = $example_storage->loadRevision(1);
    $date = $this->container->get('date.formatter')->format($entity_revision->getRevisionCreationTime());
    $short_date = $this->container->get('date.formatter')->format($entity_revision->getRevisionCreationTime(), 'short');

    $this->getSession()->getDriver()->click('//td[p[text() = "First version"]]/a[text() = "' . $short_date . '"]');
    $this->assertPageTitle(new FM('Revision of %label from %date', ['%label' => 'Beer', '%date' => $date]));

    $this->getSession()->back();

    // -- Test entity revert revision.
    $this->getSession()->getDriver()->click('//td[p[text() = "First version"]]/following-sibling::td//a[text() = "Revert"]');
    $this->assertPageTitle(new FM('Are you sure you want to revert to the revision from %date?', ['%date' => $date]));
    $this->submitForm([], 'Revert');

    $this->assertStatusMessage(new FM('@type %label has been reverted to the revision from %date.', [
      '@type' => 'Bar',
      '%label' => 'Beer',
      '%date' => $date,
    ]));

    $xpath = '//table/tbody/tr[1]/td';
    $xpath .= '/p[text() = "Copy of the revision from "]';
    $xpath .= '/em[text() = "' . $date . '"]';
    $this->assertXpath($xpath);

    // -- Test delete revision.
    $entity_revision = $example_storage->loadRevision(2);
    $date = $date_formatter->format($entity_revision->getRevisionCreationTime());

    $this->getSession()->getDriver()->click('//td[p[text() = "Second version"]]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(new FM('Are you sure you want to delete the revision from %date?', ['%date' => $date]));
    $this->submitForm([], 'Delete');

    $this->assertStatusMessage(new FM('Revision from %date of @type %label has been deleted.', [
      '@type' => 'Bar',
      '%label' => 'Wine',
      '%date' => $date,
    ]));

    $this->assertNoXpath('//td[p[text() = "Second version"]]');

    // -- Test entity list builder.
    $this->drupalGet('/admin/content/example');
    $this->assertPageTitle('Examples');

    $xpath = '//table/thead/tr[1]';
    $xpath .= '//th[text() = "ID"]';
    $xpath .= '/next::th[text() = "Label"]';
    $xpath .= '/next::th[text() = "Status"]';
    $xpath .= '/next::th[text() = "Author"]';
    $xpath .= '/next::th[text() = "Created"]';
    $xpath .= '/next::th[text() = "Updated"]';
    $xpath .= '/next::th[text() = "Operations"]';
    $this->assertXpath($xpath);

    $xpath = '//table/tbody/tr[1]';
    $xpath .= '//td[text() = "1"]';
    $xpath .= '/next::td[a[text() = "Beer"]]';
    $xpath .= '/next::td[text() = "Enabled"]';
    $xpath .= '/next::td[div/a[text() = "example_admin"]]';
    $this->assertXpath($xpath);

    // -- Test entity deletion.
    $this->getSession()->getDriver()->click('//td[text() = "1"]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(new FM('Are you sure you want to delete the example %label?', ['%label' => 'Beer']));
    $this->assertSession()->pageTextContains('This action cannot be undone');

    $this->submitForm([], 'Delete');
    $this->assertStatusMessage(new FM('The example %label has been deleted.', ['%label' => 'Beer']));
    $this->assertSession()->pageTextContains('There are no examples yet.');
  }

}
