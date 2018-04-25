<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormState;
use Drupal\KernelTests\KernelTestBase;

/**
 * A test for view argument default plugin.
 *
 * @group DCG
 */
class ViewsArgumentDefaultTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['views', 'qux'];

  /**
   * Test callback.
   */
  public function testPlugin() {

    $plugin_manager = \Drupal::service('plugin.manager.views.argument_default');

    $plugin = $plugin_manager->createInstance('qux_example');
    $plugin->options['example_option'] = 'abc';

    $expected_form['example_option'] = [
      '#type' => 'textfield',
      '#title' => t('Some example option'),
      '#default_value' => 'abc',
    ];
    $form = [];
    $plugin->buildOptionsForm($form, new FormState());
    self::assertEquals($expected_form, $form);

    self::assertEquals('abc', $plugin->getArgument());
    self::assertEquals(Cache::PERMANENT, $plugin->getCacheMaxAge());
    self::assertEquals(['url'], $plugin->getCacheContexts());
  }

}
