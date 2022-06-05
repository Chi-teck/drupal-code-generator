<?php declare(strict_types=1);

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
     • .phpstorm.meta.php

    TXT;
    $this->assertDisplay($expected_display);

    // The content of the file may vary depending on the Drupal version. So that
    // we assert specific parts of that file.
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php');

    $services = <<< 'TXT'
    <?php /** @noinspection ALL */
    
    namespace PHPSTORM_META {
    
      override(
        \Drupal::service(0),
        map([
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    TXT;
    self::assertStringContainsString($services, $generated_content);

    $entity_storages = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
        map([
          'action' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
          'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideStorage',
          'block' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
    TXT;
    self::assertStringContainsString($entity_storages, $generated_content);

    $entity_view_builders = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
        map([
          'block' => '\Drupal\block\BlockViewBuilder',
          'block_content' => '\Drupal\block_content\BlockContentViewBuilder',
          'comment' => '\Drupal\comment\CommentViewBuilder',
    TXT;
    self::assertStringContainsString($entity_view_builders, $generated_content);

    $entity_list_builders = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
        map([
          'block' => '\Drupal\block\BlockListBuilder',
          'block_content_type' => '\Drupal\block_content\BlockContentTypeListBuilder',
          'block_content' => '\Drupal\block_content\BlockContentListBuilder',
    TXT;
    self::assertStringContainsString($entity_list_builders, $generated_content);

    $access_control_handlers = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
        map([
         'block' => '\Drupal\block\BlockAccessControlHandler',
         'block_content_type' => '\Drupal\Core\Entity\EntityAccessControlHandler',
         'block_content' => '\Drupal\block_content\BlockContentAccessControlHandler',
    TXT;
    self::assertStringContainsString($access_control_handlers, $generated_content);

    $entity_static_methods = <<< 'TXT'
      override(\Drupal\block\Entity\Block::loadMultiple(), map(['' => '\Drupal\block\Entity\Block[]']));
      override(\Drupal\block\Entity\Block::load(), map(['' => '\Drupal\block\Entity\Block']));
      override(\Drupal\block\Entity\Block::create(), map(['' => '\Drupal\block\Entity\Block']));
    TXT;
    self::assertStringContainsString($entity_static_methods, $generated_content);

    $other = <<< 'TXT'
      expectedReturnValues(
        \Drupal\Core\Entity\EntityInterface::save(),
        \SAVED_NEW,
        \SAVED_UPDATED
      );
    
      expectedArguments(
        \Drupal\Core\Entity\EntityViewBuilderInterface::view(),
        2,
        \Drupal\Core\Language\LanguageInterface::LANGCODE_NOT_SPECIFIED,
        \Drupal\Core\Language\LanguageInterface::LANGCODE_NOT_APPLICABLE,
        \Drupal\Core\Language\LanguageInterface::LANGCODE_DEFAULT,
        \Drupal\Core\Language\LanguageInterface::LANGCODE_SITE_DEFAULT
      );
    
      expectedArguments(
        \Drupal\Core\Messenger\MessengerInterface::addMessage(),
        1,
        \Drupal\Core\Messenger\MessengerInterface::TYPE_STATUS,
        \Drupal\Core\Messenger\MessengerInterface::TYPE_WARNING,
        \Drupal\Core\Messenger\MessengerInterface::TYPE_ERROR
      );
    
      expectedArguments(
        \Drupal\Core\File\FileSystemInterface::prepareDirectory(),
        1,
        \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY,
        \Drupal\Core\File\FileSystemInterface::MODIFY_PERMISSIONS
      );
    
      registerArgumentsSet('file_system_exists_behaviour',
        \Drupal\Core\File\FileSystemInterface::EXISTS_RENAME,
        \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE,
        \Drupal\Core\File\FileSystemInterface::EXISTS_ERROR
      );
    
      expectedArguments(\Drupal\Core\File\FileSystemInterface::copy(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\Drupal\Core\File\FileSystemInterface::move(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\Drupal\Core\File\FileSystemInterface::saveData(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\Drupal\Core\File\FileSystemInterface::getDestinationFilename(), 1, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\file_copy(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\file_move(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\file_save_data(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\file_save_upload(), 4, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\system_retrieve_file(), 3, argumentsSet('file_system_exists_behaviour'));
    TXT;
    self::assertStringContainsString($other, $generated_content);
  }

}
