<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Helper\Drupal\ConfigInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Tests 'config info' helper.
 */
final class ConfigInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGetName(): void {
    $container = $this->application->getContainer();
    $route_info = new ConfigInfo($container->get('config.factory'));
    self::assertSame('config_info', $route_info->getName());
  }

  /**
   * Test callback.
   */
  public function testGetConfigNames(): void {
    $container = $this->application->getContainer();
    $config_info = new ConfigInfo($container->get('config.factory'));
    $config_names = $config_info->getConfigNames();
    self::assertGreaterThan(150, \count($config_names));
    self::assertContains('automated_cron.settings', $config_names);
    self::assertContains('claro.settings', $config_names);
    self::assertContains('core.entity_view_mode.node.full', $config_names);
    self::assertContains('system.site', $config_names);
    self::assertContains('views.view.content', $config_names);
  }

}
