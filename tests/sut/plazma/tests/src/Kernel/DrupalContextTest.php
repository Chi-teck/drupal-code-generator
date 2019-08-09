<?php

namespace Drupal\Tests\plazma\Kernel;

use Drupal\KernelTests\KernelTestBase;
use DrupalCodeGenerator\Helper\DrupalContext;

/**
 * Test Drupal context.
 */
class DrupalContextTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['system', 'node', 'plazma'];

  /**
   * Test callback.
   */
  public function testDrupalContext(): void {
    $drupal_context = new DrupalContext($this->container);

    $expected_modules = [
      'system' => 'System',
      'node' => 'Node',
      'foo' => 'Foo',
    ];
    self::assertEquals($expected_modules, $drupal_context->getExtensionList('module'));

    $this->container->get('theme_handler')->install(['seven']);
    $expected_themes = [
      'stable' => 'Stable',
      'classy' => 'Classy',
      'seven' => 'Seven',
    ];
    self::assertEquals($expected_themes, $drupal_context->getExtensionList('theme'));

    self::assertEquals(DRUPAL_ROOT . '/modules/foo', $drupal_context->getDestination('module', FALSE, 'foo'));
    self::assertEquals(DRUPAL_ROOT . '/modules', $drupal_context->getDestination('module', TRUE, 'foo'));
    self::assertEquals(DRUPAL_ROOT . '/themes/foo', $drupal_context->getDestination('theme', FALSE, 'foo'));
    self::assertEquals(DRUPAL_ROOT . '/themes', $drupal_context->getDestination('theme', TRUE, 'foo'));

    $hooks = $drupal_context->getHooks();
    self::assertGreaterThan(100, count($hooks));
    self::assertArrayHasKey('cron', $hooks);
    self::assertArrayHasKey('schema', $hooks);
    self::assertArrayHasKey('module_implements_alter', $hooks);
    $foo_bar_hook = [
      '/**',
      ' * Implements hook_foo_bar().',
      ' */',
      'function {{ machine_name }}_foo_bar() {',
      '  return [123];',
      '}',
      '',
    ];
    self::assertEquals(implode("\n", $foo_bar_hook), $hooks['foo_bar']);

    self::assertEquals(DRUPAL_ROOT, $drupal_context->getDrupalRoot());

    $service_ids = $drupal_context->getServicesIds();
    self::assertGreaterThan(400, count($service_ids));
    self::assertTrue(in_array('foo.bar', $service_ids));
  }

}
