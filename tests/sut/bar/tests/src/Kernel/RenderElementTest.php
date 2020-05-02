<?php

namespace Drupal\Tests\bar\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Render element test.
 *
 * @group DCG
 */
final class RenderElementTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['block', 'system', 'user', 'bar'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    \Drupal::service('theme_installer')->install(['stark']);
    \Drupal::configFactory()->getEditable('system.theme')->set('default', 'stark')->save();

    $this->container
      ->get('entity_type.manager')
      ->getStorage('block')
      ->create([
        'id' => 'test_block',
        'plugin' => 'system_powered_by_block',
        'theme' => 'stark',
        'region' => 'content',
      ])
      ->save();
  }

  /**
   * Test callback.
   */
  public function testBlockRendering(): void {

    $build = [
      '#type' => 'entity',
      '#entity_type' => 'block',
      '#entity_id' => 'test_block',
    ];

    $content = \Drupal::service('renderer')->renderRoot($build);

    $result = (new \SimpleXMLElement($content))
      ->xpath('//div[@id = "block-test-block"]/span/a[text() = "Drupal"]');

    self::assertCount(1, $result);
  }

}
