<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Helper;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use DrupalCodeGenerator\Helper\DrupalContext;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A test for Drupal context helper.
 */
final class DrupalContextTest extends TestCase {

  /**
   * Mocked container.
   */
  private ContainerInterface $container;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $this->container = $this->getMockBuilder(ContainerInterface::class)
      ->setMethods(['get'])
      ->getMock();

    $handler_map = [
      ['module_handler', $this->getModuleHandler()],
      ['theme_handler', $this->getThemeHandler()],
    ];
    $this->container->expects($this->any())
      ->method('get')
      ->will($this->returnValueMap($handler_map));

    if (!\defined('DRUPAL_ROOT')) {
      \define('DRUPAL_ROOT', '/tmp/drupal');
    }
  }

  /**
   * Test callback.
   */
  public function testGetModules(): void {
    $drupal_context = new DrupalContext($this->container);
    $modules = [
      'foo' => 'Foo',
      'bar' => 'Bar',
      'qux' => 'Qux',
    ];
    self::assertSame($modules, $drupal_context->getModules());
  }

  /**
   * Test callback.
   */
  public function testGetThemes(): void {
    $drupal_context = new DrupalContext($this->container);
    $modules = [
      'foo' => 'Foo',
      'bar' => 'Bar',
      'qux' => 'Qux',
    ];
    self::assertSame($modules, $drupal_context->getModules());
  }

  /**
   * Test callback.
   */
  public function testGetModuleDestination(): void {
    $drupal_context = new DrupalContext($this->container, '/path');
    // New module.
    self::assertSame('/path/modules', $drupal_context->getModuleDestination(TRUE, 'does not matter'));
    // Existing module.
    self::assertSame('/path/modules/custom/bar', $drupal_context->getModuleDestination(FALSE, 'bar'));
    // Existing module which is not really exists.
    self::assertSame('/path/modules/fake', $drupal_context->getModuleDestination(FALSE, 'fake'));
  }

  /**
   * Test callback.
   */
  public function testGetThemeDestination(): void {
    $drupal_context = new DrupalContext($this->container, '/path');
    // New theme.
    self::assertSame('/path/themes', $drupal_context->getThemeDestination(TRUE, 'does not matter'));
    // Existing theme.
    self::assertSame('/path/themes/gamma', $drupal_context->getThemeDestination(FALSE, 'gamma'));
  }

  /**
   * Mocks module handler.
   */
  private function getModuleHandler(): ModuleHandlerInterface {
    $module_handler = $this->getMockBuilder(ModuleHandlerInterface::class)
      ->setMethods(['getModuleList', 'getModule', 'getName'])
      ->getMock();

    $module_names = [
      'foo' => 'Foo',
      'bar' => 'Bar',
      'qux' => 'Qux',
    ];

    foreach ($module_names as $machine_name => $name) {
      $module = $this->getMockBuilder('\Drupal\Core\Extension\Extension')
        ->setMethods(['getPath'])
        ->getMock();

      $module->expects($this->any())
        ->method('getPath')
        ->willReturn('modules/custom/' . $machine_name);

      $modules[$machine_name] = $module;
      $module_map[] = [$machine_name, $module];
      $module_name_map[] = [$machine_name, $name];
    }

    $module_handler->expects($this->any())
      ->method('getModule')
      ->will($this->returnValueMap($module_map));

    $module_handler->expects($this->any())
      ->method('getName')
      ->will($this->returnValueMap($module_name_map));

    $module_handler->expects($this->any())
      ->method('getModuleList')
      ->willReturn($modules);

    return $module_handler;
  }

  /**
   * Mocks theme handler.
   */
  private function getThemeHandler(): ThemeHandlerInterface {

    // -- Theme handler.
    $theme_handler = $this->getMockBuilder(ThemeHandlerInterface::class)
      ->setMethods(['listInfo', 'getTheme', 'getName'])
      ->getMock();

    $theme_names = [
      'alpha' => 'Alpha',
      'beta' => 'Beta',
      'gamma' => 'Gamma',
    ];

    foreach ($theme_names as $machine_name => $name) {
      $theme = $this->getMockBuilder('\Drupal\Core\Extension\Extension')
        ->setMethods(['getPath'])
        ->getMock();

      $theme->expects($this->any())
        ->method('getPath')
        ->willReturn('themes/' . $machine_name);

      $theme->info['name'] = $name;

      $themes[$machine_name] = $theme;
      $theme_map[] = [$machine_name, $theme];
    }

    $theme_handler->expects($this->any())
      ->method('getTheme')
      ->will($this->returnValueMap($theme_map));

    $theme_handler->expects($this->any())
      ->method('listInfo')
      ->willReturn($themes);

    return $theme_handler;
  }

}
