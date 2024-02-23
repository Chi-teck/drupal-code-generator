<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Form\FormState;
use Drupal\filter\FilterPluginCollection;
use Drupal\KernelTests\KernelTestBase;

/**
 * Filter plugin test.
 *
 * @group DCG
 */
final class FilterTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['filter', 'qux'];

  /**
   * Test callback.
   */
  public function testFilter(): void {
    $plugin_manager = $this->container->get('plugin.manager.filter');
    $filter_collection = new FilterPluginCollection($plugin_manager);
    $filter = $filter_collection->get('example');

    self::assertSame('-=bar=-', (string) $filter->process('-=foo=-', 'en'));
    self::assertEquals('@todo Provide filter tips here.', $filter->tips());

    $settings_form = $filter->settingsForm([], new FormState());
    self::assertSame('foo', $settings_form['example']['#default_value']);
  }

}
