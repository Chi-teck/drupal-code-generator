<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\PhpStormMeta\PhpStormMeta;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests phpstorm-metadata generator.
 */
final class PhpStormMetaTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_phpstorm_meta';

  /**
   * Test callback.
   */
  public function testGenerator(): void {
    // @todo Remove this once we drop support for Drupal 10.2.
    if (\version_compare(\Drupal::VERSION, '10.3', '<')) {
      self::markTestSkipped();
    }

    $this->execute(PhpStormMeta::class, []);

    $expected_display = <<< 'TXT'

     Welcome to phpstorm-meta generator!
    –––––––––––––––––––––––––––––––––––––

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • .phpstorm.meta.php/config_entity_ids.php
     • .phpstorm.meta.php/configuration.php
     • .phpstorm.meta.php/database.php
     • .phpstorm.meta.php/date_formats.php
     • .phpstorm.meta.php/entity_bundles.php
     • .phpstorm.meta.php/entity_links.php
     • .phpstorm.meta.php/entity_types.php
     • .phpstorm.meta.php/extensions.php
     • .phpstorm.meta.php/field_definitions.php
     • .phpstorm.meta.php/fields.php
     • .phpstorm.meta.php/file_system.php
     • .phpstorm.meta.php/miscellaneous.php
     • .phpstorm.meta.php/permissions.php
     • .phpstorm.meta.php/plugins.php
     • .phpstorm.meta.php/roles.php
     • .phpstorm.meta.php/routes.php
     • .phpstorm.meta.php/services.php
     • .phpstorm.meta.php/settings.php
     • .phpstorm.meta.php/states.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('.phpstorm.meta.php/config_entity_ids.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/configuration.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/database.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/date_formats.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/entity_bundles.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/entity_links.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/field_definitions.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/fields.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/file_system.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/miscellaneous.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/permissions.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/roles.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/routes.php');
    // The content of some files may vary depending on the Drupal version. So
    // that we only assert specific parts of those files.
    $this->assertPlugins();
    $this->assertEntityTypes();
    $this->assertExtensions();
    $this->assertServices();
    $this->assertSettings();
    $this->assertStates();
  }

  /**
   * @selfdoc
   */
  private function assertPlugins(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/plugins.php');

    // Check the beginning of the file.
    $entity_types = <<< 'PHP'
    <?php

    declare(strict_types=1);

    namespace PHPSTORM_META {

      // -- breakpoint.manager.
      registerArgumentsSet('breakpoint.manager__plugin_ids',
        'olivero.grid-max',
        'olivero.grid-md',
        'olivero.lg',
        'olivero.md',
        'olivero.nav',
        'olivero.nav-md',
        'olivero.sm',
        'olivero.xl',
        'toolbar.narrow',
        'toolbar.standard',
        'toolbar.wide',
      );
      expectedArguments(\Drupal\breakpoint\BreakpointManager::createInstance(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManager::getDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManager::hasDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManager::processDefinition(), 1, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::createInstance(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::getDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::hasDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
      expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::processDefinition(), 1, argumentsSet('breakpoint.manager__plugin_ids'));
    PHP;
    self::assertStringContainsString($entity_types, $generated_content);

    // Check the middle of the file.
    $entity_types = <<< 'PHP'

      // -- image.toolkit.manager.
      override(\Drupal\Core\ImageToolkit\ImageToolkitManager::createInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitInterface']));
      override(\Drupal\Core\ImageToolkit\ImageToolkitManager::getInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitInterface|bool']));
      registerArgumentsSet('image.toolkit.manager__plugin_ids',
        'gd',
      );
      expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::createInstance(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
      expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::getDefinition(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
      expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::hasDefinition(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
      expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::processDefinition(), 1, argumentsSet('image.toolkit.manager__plugin_ids'));
    
    PHP;
    self::assertStringContainsString($entity_types, $generated_content);

    // Check the end of the file.
    $entity_types = <<< 'PHP'
        'ValidReference',
      );
      expectedArguments(\Drupal\Core\Validation\ConstraintManager::createInstance(), 0, argumentsSet('validation.constraint__plugin_ids'));
      expectedArguments(\Drupal\Core\Validation\ConstraintManager::getDefinition(), 0, argumentsSet('validation.constraint__plugin_ids'));
      expectedArguments(\Drupal\Core\Validation\ConstraintManager::hasDefinition(), 0, argumentsSet('validation.constraint__plugin_ids'));
      expectedArguments(\Drupal\Core\Validation\ConstraintManager::processDefinition(), 1, argumentsSet('validation.constraint__plugin_ids'));
      expectedArguments(\Drupal\Core\Entity\EntityTypeInterface::addConstraint(), 0, argumentsSet('validation.constraint__plugin_ids'));
      expectedArguments(\Drupal\Core\TypedData\DataDefinitionInterface::addConstraint(), 0, argumentsSet('validation.constraint__plugin_ids'));
    
    }
    PHP;
    self::assertStringContainsString($entity_types, $generated_content);

    // Make sure all plugin types are in place.
    self::assertStringContainsString('breakpoint.manager__plugin_ids', $generated_content);
    self::assertStringContainsString('config.typed__plugin_ids', $generated_content);
    self::assertStringContainsString('entity_type.manager__plugin_ids', $generated_content);
    self::assertStringContainsString('image.toolkit.manager__plugin_ids', $generated_content);
    self::assertStringContainsString('image.toolkit.operation.manager__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.action__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.archiver__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.block__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.ckeditor5.plugin__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.condition__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.display_variant__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.editor__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.element_info__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.entity_reference_selection__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.field.field_type__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.field.formatter__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.field.widget__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.filter__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.help_section__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.image.effect__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.link_relation_type__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.mail__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.menu.contextual_link__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.menu.local_action__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.menu.local_task__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.search__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.access__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.area__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.argument__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.argument_default__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.argument_validator__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.cache__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.display__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.display_extender__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.exposed_form__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.field__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.filter__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.join__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.pager__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.query__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.relationship__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.row__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.sort__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.style__plugin_ids', $generated_content);
    self::assertStringContainsString('plugin.manager.views.wizard__plugin_ids', $generated_content);
    self::assertStringContainsString('typed_data_manager__plugin_ids', $generated_content);
    self::assertStringContainsString('validation.constraint__plugin_ids', $generated_content);

    self::assertSame(49, \substr_count($generated_content, 'registerArgumentsSet'));
  }

  /**
   * {@selfdoc}
   */
  private function assertEntityTypes(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_types.php');

    $entity_types = <<< 'PHP'
      <?php

      declare(strict_types=1);

      namespace PHPSTORM_META {

        // Entity types.
        registerArgumentsSet('entity_type_ids',
          'action',
          'base_field_override',
          'block',
          'block_content',
          'block_content_type',
          'comment',
      PHP;
    self::assertStringContainsString($entity_types, $generated_content);
  }

  private function assertExtensions(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/extensions.php');
    // Testing environments may have different database drivers.
    $modules = <<< 'PHP'
    <?php

    declare(strict_types=1);
    
    namespace PHPSTORM_META {
    
      registerArgumentsSet('modules',
        'announcements_feed',
        'automated_cron',
        'big_pipe',
        'block',
        'block_content',
        'breakpoint',
    PHP;
    self::assertStringContainsString($modules, $generated_content);

    $themes = <<< 'PHP'
      registerArgumentsSet('themes',
        'claro',
        'olivero',
      );
      expectedArguments(\Drupal\Core\Extension\ThemeHandlerInterface::getBaseThemes(), 1, argumentsSet('themes'));
      expectedArguments(\Drupal\Core\Extension\ThemeHandlerInterface::getName(), 0, argumentsSet('themes'));
      expectedArguments(\Drupal\Core\Extension\ThemeHandlerInterface::themeExists(), 0, argumentsSet('themes'));
      expectedArguments(\Drupal\Core\Extension\ThemeHandlerInterface::getTheme(), 0, argumentsSet('themes'));
      expectedArguments(\Drupal\Core\Extension\ThemeHandlerInterface::hasUi(), 0, argumentsSet('themes'));
      expectedReturnValues(\Drupal\Core\Extension\ThemeHandlerInterface::getDefault(), argumentsSet('themes'));
      expectedReturnValues(\Drupal\Core\Theme\ActiveTheme::getName(), argumentsSet('themes'));
    PHP;
    self::assertStringContainsString($themes, $generated_content);
  }

  private function assertServices(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/services.php');

    $services_1 = <<< 'PHP'
    <?php

    declare(strict_types=1);

    namespace PHPSTORM_META {

      override(
        \Drupal::service(0),
        map([
          '.service_locator.8a319vC' => '\Symfony\Component\DependencyInjection\ServiceLocator',
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.admin_menu_block_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
          'access_check.admin_overview_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    PHP;
    self::assertStringContainsString($services_1, $generated_content);

    $services_2 = <<< 'PHP'
      override(
        \Symfony\Component\DependencyInjection\ContainerInterface::get(0),
        map([
          '.service_locator.8a319vC' => '\Symfony\Component\DependencyInjection\ServiceLocator',
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.admin_menu_block_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
          'access_check.admin_overview_page' => '\Drupal\system\Access\SystemAdminMenuBlockAccessCheck',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
          'access_check.csrf' => '\Drupal\Core\Access\CsrfAccessCheck',
    PHP;
    self::assertStringContainsString($services_2, $generated_content);
  }

  private function assertSettings(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/settings.php');
    // The full list of settings depends on environment.
    $settings = <<< 'PHP'
        'hash_salt',
        'update_free_access',
        'container_yamls',
        'file_scan_ignore_directories',
        'entity_update_batch_size',
        'entity_update_backup',
        'state_cache',
        'migrate_node_migrate_type_classic',
        'config_sync_directory',
    PHP;
    self::assertStringContainsString($settings, $generated_content);
  }

  private function assertStates(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/states.php');
    // The full list of states depends on environment.
    $states = <<< 'PHP'
    <?php
    
    declare(strict_types=1);
    
    namespace PHPSTORM_META {

      registerArgumentsSet('states',
        'announcements_feed.last_fetch',
        'asset.css_js_query_string',
        'comment.maintain_entity_statistics',
        'comment.node_comment_statistics_scale',
        'help_search_unindexed_count',
        'install_task',
    PHP;
    self::assertStringContainsString($states, $generated_content);

    $arguments = <<< 'PHP'
      expectedArguments(\Drupal\Core\State\StateInterface::get(), 0, argumentsSet('states'));
      expectedArguments(\Drupal\Core\State\StateInterface::set(), 0, argumentsSet('states'));
      expectedArguments(\Drupal\Core\State\StateInterface::delete(), 0, argumentsSet('states'));
    PHP;
    self::assertStringContainsString($arguments, $generated_content);
  }

}
