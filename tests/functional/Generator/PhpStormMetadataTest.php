<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\PhpStormMetadata;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests phpstorm-metadata generator.
 */
final class PhpStormMetadataTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_phpstorm_metadata';

  public function testGenerator(): void {

    $this->execute(PhpStormMetadata::class, []);

    $expected_display = <<< 'TXT'

     Welcome to phpstorm-meta generator!
    –––––––––––––––––––––––––––––––––––––

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • .phpstorm.meta.php/configuration.php
     • .phpstorm.meta.php/date_formats.php
     • .phpstorm.meta.php/entity_bundles.php
     • .phpstorm.meta.php/entity_links.php
     • .phpstorm.meta.php/entity_types.php
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

    // The content of some files may vary depending on the Drupal version. So
    // that we only assert specific parts of those files.
    $this->assertGeneratedFile('.phpstorm.meta.php/configuration.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/date_formats.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/entity_bundles.php');
    $this->assertEntityTypes();
    $this->assertGeneratedFile('.phpstorm.meta.php/entity_links.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/field_definitions.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/fields.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/file_system.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/miscellaneous.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/permissions.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/plugins.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/roles.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/routes.php');
    $this->assertServices();
    $this->assertSettings();
    $this->assertStates();
  }

  private function assertEntityTypes(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_types.php');

    $entity_types = <<< 'PHP'
      expectedReturnValues(
        \Drupal\Core\Entity\EntityInterface::getEntityTypeId(),
        'action',
        'base_field_override',
        'block',
        'block_content',
        'block_content_type',
    PHP;
    self::assertStringContainsString($entity_types, $generated_content);

    $entity_storages = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
        map([
          'action' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
          'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideStorage',
          'block' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
    PHP;
    self::assertStringContainsString($entity_storages, $generated_content);

    $entity_view_builders = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
        map([
          'block' => '\Drupal\block\BlockViewBuilder',
          'block_content' => '\Drupal\block_content\BlockContentViewBuilder',
          'comment' => '\Drupal\comment\CommentViewBuilder',
    PHP;
    self::assertStringContainsString($entity_view_builders, $generated_content);

    $entity_list_builders = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
        map([
          'block' => '\Drupal\block\BlockListBuilder',
          'block_content' => '\Drupal\block_content\BlockContentListBuilder',
          'block_content_type' => '\Drupal\block_content\BlockContentTypeListBuilder',
    PHP;
    self::assertStringContainsString($entity_list_builders, $generated_content);

    $access_control_handlers = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
        map([
         'action' => '\Drupal\Core\Entity\EntityAccessControlHandler',
         'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideAccessControlHandler',
         'block' => '\Drupal\block\BlockAccessControlHandler',
    PHP;
    self::assertStringContainsString($access_control_handlers, $generated_content);

    $entity_static_methods = <<< 'PHP'
      override(\Drupal\block\Entity\Block::loadMultiple(), map(['' => '\Drupal\block\Entity\Block[]']));
      override(\Drupal\block\Entity\Block::load(), map(['' => '\Drupal\block\Entity\Block']));
      override(\Drupal\block\Entity\Block::create(), map(['' => '\Drupal\block\Entity\Block']));
    PHP;
    self::assertStringContainsString($entity_static_methods, $generated_content);
  }

  private function assertServices(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/services.php');

    $services_1 = <<< 'PHP'
    <?php declare(strict_types = 1);

    namespace PHPSTORM_META {

      override(
        \Drupal::service(0),
        map([
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    PHP;
    self::assertStringContainsString($services_1, $generated_content);

    $services_2 = <<< 'PHP'
      override(
        \Symfony\Component\DependencyInjection\ContainerInterface::get(0),
        map([
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    PHP;
    self::assertStringContainsString($services_2, $generated_content);
  }

  private function assertSettings(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/settings.php');
    // The full list of settings depends on environment.
    $settings = <<< 'PHP'
        'container_yamls',
        'file_scan_ignore_directories',
        'entity_update_batch_size',
        'entity_update_backup',
        'migrate_node_migrate_type_classic',
    PHP;
    self::assertStringContainsString($settings, $generated_content);
  }

  private function assertStates(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/states.php');
    // The full list of states depends on environment.
    $states = <<< 'PHP'
    <?php declare(strict_types = 1);
    
    namespace PHPSTORM_META {

      registerArgumentsSet('states',
        'comment.maintain_entity_statistics',
        'comment.node_comment_statistics_scale',
        'install_task',
        'install_time',
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
