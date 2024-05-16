<?php

declare(strict_types=1);

namespace Drupal\Tests\lamda\Kernel;

use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Plugin manager test.
 */
#[Group('DCG')]
final class PluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['lamda'];

  /**
   * Test callback.
   */
  public function testPluginManagerAnnotation(): void {
    $plugin_manager = $this->container->get('plugin.manager.alpha');

    $definition = $plugin_manager->getDefinition('foo');

    $expected_definition = [
      'id' => 'foo',
      'label' => 'Foo',
      'description' => 'Foo description.',
      'class' => 'Drupal\lamda\Plugin\Alpha\Foo',
    ];
    self::assertPluginDefinition($expected_definition, $definition);

    $plugin = $plugin_manager->createInstance('foo');
    self::assertSame('Foo', $plugin->label());
  }

  /**
   * Test callback.
   */
  public function testPluginManagerYaml(): void {
    $plugin_manager = $this->container->get('plugin.manager.beta');

    for ($i = 1; $i <= 3; $i++) {
      $plugin_id = 'lamda.example_' . $i;
      $plugin_label = 'Example ' . $i;
      $definition = $plugin_manager->getDefinition($plugin_id);

      $expected_definition = [
        'id' => $plugin_id,
        'label' => $plugin_label,
        'description' => 'Plugin description.',
        'class' => 'Drupal\lamda\BetaDefault',
      ];
      self::assertPluginDefinition($expected_definition, $definition);

      $plugin = $plugin_manager->createInstance($plugin_id);
      self::assertSame($plugin_label, $plugin->label());
    }
  }

  /**
   * Test callback.
   */
  public function testPluginManagerHook(): void {
    $plugin_manager = $this->container->get('plugin.manager.gamma');

    // Foo plugin.
    $definition = $plugin_manager->getDefinition('lamda.foo');

    $expected_definition = [
      'id' => 'foo',
      'label' => 'Foo',
      'description' => 'Foo description.',
      'class' => 'Drupal\lamda\GammaDefault',
    ];
    self::assertPluginDefinition($expected_definition, $definition);

    $plugin = $plugin_manager->createInstance('lamda.foo');
    self::assertSame('Foo', $plugin->label());

    // Bar plugin.
    $definition = $plugin_manager->getDefinition('lamda.bar');

    $expected_definition = [
      'id' => 'bar',
      'label' => 'Bar',
      'description' => 'Bar description.',
      'class' => 'Drupal\lamda\GammaDefault',
    ];
    self::assertPluginDefinition($expected_definition, $definition);

    $plugin = $plugin_manager->createInstance('lamda.bar');
    self::assertSame('Bar', $plugin->label());
  }

  /**
   * Asserts plugin definition.
   */
  private static function assertPluginDefinition(array $expected_definition, array $actual_definition): void {
    $actual_definition = [
      'id' => $actual_definition['id'],
      'label' => (string) $actual_definition['label'],
      'description' => (string) $actual_definition['description'],
      'class' => $actual_definition['class'],
    ];
    self::assertSame($expected_definition, $actual_definition);
  }

}
