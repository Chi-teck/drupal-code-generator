<?php

namespace Drupal\Tests\acme\Kernel;

use Drupal\acme\Entity\Bundle\ArticleBundle;
use Drupal\acme\Entity\Bundle\NodeBundle;
use Drupal\acme\Entity\Bundle\PageBundle;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Test description.
 *
 * @group acme
 */
final class BundleClassTest extends KernelTestBase {

  use NodeCreationTrait;
  use ContentTypeCreationTrait {
    createContentType as drupalCreateContentType;
  }

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'system', 'acme', 'node', 'filter', 'user', 'field', 'text',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installConfig(['node', 'filter', 'acme']);

    $this->installEntitySchema('user');
    $this->installEntitySchema('node');

    $this->drupalCreateContentType(['type' => 'page']);
    $this->drupalCreateContentType(['type' => 'article']);
  }

  /**
   * Test callback.
   */
  public function testBundleClass(): void {
    $node_1 = $this->createNode(['type' => 'page']);
    self::assertInstanceOf(NodeBundle::class, $node_1);
    self::assertInstanceOf(PageBundle::class, $node_1);

    $node_2 = $this->createNode(['type' => 'article']);
    self::assertInstanceOf(NodeBundle::class, $node_2);
    self::assertInstanceOf(ArticleBundle::class, $node_2);
  }

}
