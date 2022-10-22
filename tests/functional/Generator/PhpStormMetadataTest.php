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

     Welcome to phpstorm-metadata generator!
    –––––––––––––––––––––––––––––––––––––––––

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • .phpstorm.meta.php/configuration.php
     • .phpstorm.meta.php/entity_type.php
     • .phpstorm.meta.php/field.php
     • .phpstorm.meta.php/file_system.php
     • .phpstorm.meta.php/miscellaneous.php
     • .phpstorm.meta.php/permission.php
     • .phpstorm.meta.php/plugin.php
     • .phpstorm.meta.php/role.php
     • .phpstorm.meta.php/route.php
     • .phpstorm.meta.php/service.php

    TXT;
    $this->assertDisplay($expected_display);

    // The content of some files may vary depending on the Drupal version. So
    // that we only assert specific parts of those files.
    $this->assertServices();
    $this->assertEntityStorages();
    $this->assertEntityViewBuilders();
    $this->assertEntityListBuilders();
    $this->assertControlHandlers();
    $this->assertEntityStaticMethods();
    $this->assertGeneratedFile('.phpstorm.meta.php/plugin.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/miscellaneous.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/route.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/configuration.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/field.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/role.php');
    $this->assertGeneratedFile('.phpstorm.meta.php/permission.php');
  }

  private function assertServices(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/service.php');
    $services_1 = <<< 'PHP'
    <?php /** @noinspection ALL */
    
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

  private function assertEntityStorages(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_type.php');
    $entity_storages = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
        map([
          'action' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
          'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideStorage',
          'block' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
    PHP;
    self::assertStringContainsString($entity_storages, $generated_content);
  }

  private function assertEntityViewBuilders(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_type.php');
    $entity_view_builders = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
        map([
          'block' => '\Drupal\block\BlockViewBuilder',
          'block_content' => '\Drupal\block_content\BlockContentViewBuilder',
          'comment' => '\Drupal\comment\CommentViewBuilder',
    PHP;
    self::assertStringContainsString($entity_view_builders, $generated_content);
  }

  private function assertEntityListBuilders(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_type.php');
    $entity_list_builders = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
        map([
          'block' => '\Drupal\block\BlockListBuilder',
          'block_content' => '\Drupal\block_content\BlockContentListBuilder',
          'block_content_type' => '\Drupal\block_content\BlockContentTypeListBuilder',
    PHP;
    self::assertStringContainsString($entity_list_builders, $generated_content);
  }

  private function assertControlHandlers(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_type.php');
    $access_control_handlers = <<< 'PHP'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
        map([
         'action' => '\Drupal\Core\Entity\EntityAccessControlHandler',
         'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideAccessControlHandler',
         'block' => '\Drupal\block\BlockAccessControlHandler',
    PHP;
    self::assertStringContainsString($access_control_handlers, $generated_content);
  }

  private function assertEntityStaticMethods(): void {
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php/entity_type.php');
    $entity_static_methods = <<< 'PHP'
      override(\Drupal\block\Entity\Block::loadMultiple(), map(['' => '\Drupal\block\Entity\Block[]']));
      override(\Drupal\block\Entity\Block::load(), map(['' => '\Drupal\block\Entity\Block']));
      override(\Drupal\block\Entity\Block::create(), map(['' => '\Drupal\block\Entity\Block']));
    PHP;
    self::assertStringContainsString($entity_static_methods, $generated_content);
  }

}
