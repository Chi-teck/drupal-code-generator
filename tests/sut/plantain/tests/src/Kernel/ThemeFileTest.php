<?php

namespace Drupal\Tests\plantain\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests theme file.
 *
 * @group DCG
 */
final class ThemeFileTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['plantain'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->container->get('theme_installer')->install(['shreya']);
    $this->container->get('extension.list.theme')->get('shreya')->load();
  }

  /**
   * Test callback.
   */
  public function testThemeFile(): void {
    // There is not a lot we can test here. Just call the preprocess functions
    // to make sure they are loaded.
    $variables = [];
    shreya_preprocess_html($variables);
    \shreya_preprocess_page($variables);
    \shreya_preprocess_node($variables);
  }

}
