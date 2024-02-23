<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormState;
use Drupal\KernelTests\KernelTestBase;

/**
 * A test for view argument default plugin.
 *
 * @group DCG
 */
final class ViewsArgumentDefaultTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['views', 'qux'];

  /**
   * Test callback.
   */
  public function testPlugin(): void {

    $plugin_manager = $this->container->get('plugin.manager.views.argument_default');

    $plugin = $plugin_manager->createInstance('qux_example');
    $plugin->options['example'] = 'abc';

    $expected_form['example'] = [
      '#type' => 'textfield',
      '#title' => 'Example',
      '#default_value' => 'abc',
    ];
    $form = [];
    $plugin->buildOptionsForm($form, new FormState());
    self::assertEquals($expected_form, $form);

    self::assertEquals('123', $plugin->getArgument());
    self::assertSame(Cache::PERMANENT, $plugin->getCacheMaxAge());
    self::assertSame([], $plugin->getCacheContexts());
  }

}
