<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Form\FormState;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test for EntityReferenceSelection plugin.
 */
#[Group('DCG')]
final class EntityReferenceSelectionTest extends KernelTestBase {

  use ContentTypeCreationTrait;
  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'user',
    'system',
    'filter',
    'field',
    'text',
    'qux',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installSchema('node', 'node_access');
    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installConfig('filter');
    $this->installConfig('node');

    $this->createContentType(['type' => 'page']);
    $this->createNode(['title' => 'Alpha'])->save();
    $this->createNode(['title' => 'Beta'])->save();
    $this->createNode(['title' => 'Gamma'])->save();
  }

  /**
   * Test callback.
   */
  public function testEntityReferenceSelection(): void {
    $plugin = $this->container->get('plugin.manager.entity_reference_selection')
      ->createInstance('qux_example', ['target_type' => 'node']);

    // Check that a configuration form has correct default value.
    $form = $plugin->buildConfigurationForm([], new FormState());
    self::assertEquals('bar', $form['foo']['#default_value']);

    self::assertSame(
      [],
      $plugin->getReferenceableEntities('example'),
    );

    self::assertSame(
      [
        'page' => [
          1 => 'Alpha',
          2 => 'Beta',
          3 => 'Gamma',
        ],
      ],
      $plugin->getReferenceableEntities('a'),
    );

    self::assertSame(
      [
        'page' => [2 => 'Beta'],
      ],
      $plugin->getReferenceableEntities('Be'),
    );
  }

}
