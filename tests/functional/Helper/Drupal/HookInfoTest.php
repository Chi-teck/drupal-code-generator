<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Helper\Drupal;

use DrupalCodeGenerator\Helper\Drupal\HookInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Console\Helper\HelperInterface;

/**
 * Tests 'hook info' helper.
 */
final class HookInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testHelper(): void {
    $hook_info = new HookInfo(self::bootstrap()->get('module_handler'));
    self::assertSame('hook_info', $hook_info->getName());
    self::assertInstanceOf(HelperInterface::class, $hook_info);
  }

  /**
   * Test callback.
   */
  public function testHookInfoTemplates(): void {
    $hook_info = new HookInfo(self::bootstrap()->get('module_handler'));
    $hook_templates = $hook_info->getHookTemplates();
    self::assertGreaterThan(260, \count($hook_templates));
    self::assertLessThan(266, \count($hook_templates));

    // A hook from core.api.php file.
    self::assertHookTemplate('data_type_info_alter', $hook_templates);
    // A hook from database.api.php file.
    self::assertHookTemplate('query_alter', $hook_templates);
    // A hook from entity.api.php file.
    self::assertHookTemplate('entity_field_values_init', $hook_templates);
    // A hook from file.api file.
    self::assertHookTemplate('file_validate', $hook_templates);
    // A hook from system.api file.
    self::assertHookTemplate('system_themes_page_alter', $hook_templates);
    // A hook from user.api.php file.
    self::assertHookTemplate('user_format_name_alter', $hook_templates);

    // A hook for install file.
    self::assertHookTemplate('install', $hook_templates);
    // A hook for views.inc file.
    self::assertHookTemplate('views_query_substitutions', $hook_templates);
    // A hook for views_execution.inc file.
    self::assertHookTemplate('views_pre_build', $hook_templates);
    // A hook for tokens.inc file.
    self::assertHookTemplate('tokens_alter', $hook_templates);
    // A hook for post_update.php file.
    self::assertHookTemplate('post_update_NAME', $hook_templates);
  }

  /**
   * Test callback.
   */
  public function testGetFileType(): void {
    self::assertSame('module', HookInfo::getFileType('hook_page_attachments'));
    self::assertSame('install', HookInfo::getFileType('schema'));
    self::assertSame('views.inc', HookInfo::getFileType('views_analyze'));
    self::assertSame('views_execution.inc', HookInfo::getFileType('views_pre_render'));
    self::assertSame('tokens.inc', HookInfo::getFileType('token_info_alter'));
    self::assertSame('post_update.php', HookInfo::getFileType('post_update_NAME'));
  }

  /**
   * Asserts hook template.
   */
  private static function assertHookTemplate(string $hook_name, array $hook_templates): void {
    self::assertArrayHasKey($hook_name, $hook_templates);
    self::assertStringEqualsFile(__DIR__ . '/hook_fixtures/' . $hook_name . '.twig', $hook_templates[$hook_name]);
  }

}
