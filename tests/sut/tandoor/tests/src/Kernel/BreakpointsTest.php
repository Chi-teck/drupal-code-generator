<?php

declare(strict_types=1);

namespace Drupal\Tests\tandoor\Kernel;

use Drupal\breakpoint\Breakpoint;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests breakpoints.
 *
 * @group DCG
 */
final class BreakpointsTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['breakpoint'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->container->get('theme_installer')->install(['azalea']);
  }

  /**
   * Test callback.
   */
  public function testBreakpoints(): void {
    $breakpoints = $this->container
      ->get('breakpoint.manager')
      ->getBreakpointsByGroup('azalea');

    self::assertCount(5, $breakpoints);

    $expected_breakpoint = [
      'label' => 'mobile',
      'weight' => 0,
      'media_query' => '',
      'multipliers' => ['1x'],
    ];
    self::assertBreakpoint($expected_breakpoint, $breakpoints['azalea.extra_small']);

    $expected_breakpoint = [
      'label' => 'mobile',
      'weight' => 1,
      'media_query' => 'all and (min-width: 576px) and (max-width: 767px)',
      'multipliers' => ['1x'],
    ];
    self::assertBreakpoint($expected_breakpoint, $breakpoints['azalea.small']);

    $expected_breakpoint = [
      'label' => 'narrow',
      'weight' => 2,
      'media_query' => 'all and (min-width: 768px) and (max-width: 991px)',
      'multipliers' => ['1x'],
    ];
    self::assertBreakpoint($expected_breakpoint, $breakpoints['azalea.medium']);

    $expected_breakpoint = [
      'label' => 'wide',
      'weight' => 3,
      'media_query' => 'all and (min-width: 992px) and (max-width: 1199px)',
      'multipliers' => ['1x'],
    ];
    self::assertBreakpoint($expected_breakpoint, $breakpoints['azalea.large']);

    $expected_breakpoint = [
      'label' => 'wide',
      'weight' => 4,
      'media_query' => 'all and (min-width: 1200px)',
      'multipliers' => ['1x'],
    ];
    self::assertBreakpoint($expected_breakpoint, $breakpoints['azalea.extra_large']);
  }

  /**
   * Asserts breakpoint.
   */
  private static function assertBreakpoint(array $expected_breakpoint, Breakpoint $breakpoint): void {
    self::assertEquals($expected_breakpoint['label'], $breakpoint->getLabel());
    self::assertSame($expected_breakpoint['media_query'], $breakpoint->getMediaQuery());
    self::assertSame($expected_breakpoint['weight'], $breakpoint->getWeight());
    self::assertSame($expected_breakpoint['multipliers'], $breakpoint->getMultipliers());
  }

}
