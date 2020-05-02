<?php

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
  public static $modules = ['filter', 'qux'];

  /**
   * Test callback.
   */
  public function testFilter(): void {

    $plugin_manager = \Drupal::service('plugin.manager.filter');

    $filter_collection = new FilterPluginCollection($plugin_manager);
    $filter = $filter_collection->get('example');

    self::assertSame('123 <b>foo</b> 456', (string) $filter->process('123 foo 456', 'en'));
    self::assertEquals('Some filter tips here.', $filter->tips());

    $settings_form = $filter->settingsForm([], new FormState());
    self::assertSame('foo', $settings_form['example']['#default_value']);
  }

}
