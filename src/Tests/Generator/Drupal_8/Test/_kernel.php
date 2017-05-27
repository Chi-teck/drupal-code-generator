<?php

namespace Drupal\Tests\foo\Kernel;

use Drupal\block\Entity\Block;
use Drupal\KernelTests\KernelTestBase;

/**
 * Example test.
 *
 * @group foo
 */
class ExampleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['block', 'system', 'user'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->container
      ->get('entity_type.manager')
      ->getStorage('block')
      ->create([
        'id' => 'test_block',
        'theme' => 'stark',
        'plugin' => 'system_powered_by_block',
      ])
      ->save();
  }

  /**
   * Tests the rendering of blocks.
   */
  public function testBlockRendering() {
    $entity = Block::load('test_block');

    $build = \Drupal::entityTypeManager()
      ->getViewBuilder($entity->getEntityTypeId())
      ->view($entity);

    $content = $this
      ->container
      ->get('renderer')
      ->renderRoot($build);

    $this->assertTrue(
      strpos(strip_tags($content), 'Powered by Drupal') !== FALSE,
      'Block content is correct'
    );
  }

}
