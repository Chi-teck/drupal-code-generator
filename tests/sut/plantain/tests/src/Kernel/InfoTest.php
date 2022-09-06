<?php declare(strict_types = 1);

namespace Drupal\Tests\plantain\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests theme info.
 *
 * @group DCG
 */
final class InfoTest extends KernelTestBase {

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
  }

  /**
   * Test callback.
   */
  public function testInfo(): void {
    $theme = $this->container
      ->get('theme_handler')
      ->getTheme('shreya');
    self::assertSame('theme', $theme->getType());
    self::assertSame('shreya', $theme->getName());
    self::assertSame('shreya.info.yml', $theme->getFilename());
    self::assertThemeInfo($theme->info);
  }

  /**
   * Asserts theme info.
   */
  private static function assertThemeInfo(array $info): void {
    $expected_info = [
      'name' => 'Shreya',
      'type' => 'theme',
      'base theme' => 'claro',
      'description' => 'Helper theme for testing DCG components.',
      'package' => 'DCG',
      'core_version_requirement' => '^10',
      'libraries' => ['shreya/global'],
      'regions' =>
        [
          'header' => 'Header',
          'primary_menu' => 'Primary menu',
          'secondary_menu' => 'Secondary menu',
          'page_top' => 'Page top',
          'page_bottom' => 'Page bottom',
          'featured' => 'Featured',
          'breadcrumb' => 'Breadcrumb',
          'content' => 'Content',
          'sidebar_first' => 'Sidebar first',
          'sidebar_second' => 'Sidebar second',
          'footer' => 'Footer',
        ],
      'core_incompatible' => FALSE,
      'lifecycle' => 'stable',
      'engine' => 'twig',
      'features' =>
        [
          'favicon',
          'logo',
          'node_user_picture',
          'comment_user_picture',
          'comment_user_verification',
        ],
      'screenshot' => 'themes/shreya/screenshot.png',
      'version' => NULL,
      'php' => '8.1.0',
      'libraries_extend' => [],
      'libraries_override' => [],
      'dependencies' => ['claro'],
    ];
    unset($info['mtime']);
    self::assertSame($expected_info, $info);
  }

}
