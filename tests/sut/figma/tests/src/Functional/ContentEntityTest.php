<?php declare(strict_types = 1);

namespace Drupal\Tests\figma\Functional;

use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\dcg_test\TestTrait;
use Drupal\figma\Entity\Example;
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
  protected static $modules = ['figma'];

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
    ];
    $admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($admin_user);

    /** @var \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type */
    $entity_type = $this->container->get('entity_type.manager')->getDefinition('example');

    // -- Test bundle properties.
    self::assertSame('example', $entity_type->getBaseTable());
    self::assertSame('Drupal\figma\Entity\Example', $entity_type->getClass());
    self::assertSame('Drupal\Core\Entity\EntityAccessControlHandler', $entity_type->getAccessControlClass());
    self::assertSame('administer example', $entity_type->getAdminPermission());
    self::assertNull($entity_type->getBundleEntityType());
    self::assertSame('Example bundle', $entity_type->getBundleLabel());
    self::assertNull($entity_type->getDataTable());

    $handlers = [
      'list_builder' => 'Drupal\figma\ExampleListBuilder',
      'views_data' => 'Drupal\views\EntityViewsData',
      'form' => [
        'add' => 'Drupal\figma\Form\ExampleForm',
        'edit' => 'Drupal\figma\Form\ExampleForm',
        'delete' => 'Drupal\Core\Entity\ContentEntityDeleteForm',
        'delete-multiple-confirm' => 'Drupal\Core\Entity\Form\DeleteMultipleForm',
      ],
      'route_provider' => [
        'html' => 'Drupal\figma\Routing\ExampleHtmlRouteProvider',
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
      'edit-form' => '/example/{example}',
      'delete-form' => '/example/{example}/delete',
      'delete-multiple-form' => '/admin/content/example/delete-multiple',
    ];
    self::assertSame($link_templates, $entity_type->getLinkTemplates());

    $keys = [
      'id' => 'id',
      'label' => 'id',
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
      'status[value]' => TRUE,
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FM('New example %label has been created.', ['%label' => '1']));
    $this->assertSession()->addressEquals('/admin/content/example');

    // -- Test entity form.
    $this->drupalGet('/example/1/edit');
    // The entity edit form only available on canonical URL.
    $this->assertSession()->statusCodeEquals(404);
    $this->drupalGet('/example/1');
    $this->assertPageTitle(new FM('Edit %label', ['%label' => 1]));
    $this->assertXpath('//input[@name = "status[value]" and @value = "1"]/following-sibling::label[text() = "Enabled"]');

    // -- Test entity values.
    $entity = Example::load(1);
    self::assertSame('1', $entity->id());
    self::assertSame('1', $entity->label());
    self::assertSame('1', $entity->get('status')->value);

    $edit = [
      'status[value]' => FALSE,
    ];
    $this->submitForm($edit, 'Save');
    $this->assertStatusMessage(new FM('The example %label has been updated.', ['%label' => '1']));
    $this->assertPageTitle('Examples');

    // -- Test entity list builder.
    $this->drupalGet('/admin/content/example');
    $this->assertPageTitle('Examples');

    $xpath = <<< 'XPATH'
      //table/thead/tr[1]//th[text() = "ID"]
      /following-sibling::th[text() = "Status"][1]
      /following-sibling::th[text() = "Operations"][1]
    XPATH;
    $this->assertXpath($xpath);

    $xpath = <<< 'XPATH'
      //table/tbody/tr[1]//td[text() = "1"]
      /following-sibling::td[text() = "Disabled"][1]
    XPATH;
    $this->assertXpath($xpath);

    // -- Test entity deletion.
    $this->getSession()->getDriver()->click('//td[text() = "1"]/following-sibling::td//a[text() = "Delete"]');
    $this->assertPageTitle(new FM('Are you sure you want to delete the example %label?', ['%label' => '1']));
    $this->assertSession()->pageTextContains('This action cannot be undone');

    $this->submitForm([], 'Delete');
    $this->assertStatusMessage(new FM('The example %label has been deleted.', ['%label' => '1']));
    $this->assertSession()->pageTextContains('There are no examples yet.');
  }

}
