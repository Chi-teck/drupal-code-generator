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
     • .phpstorm.meta.php

    TXT;
    $this->assertDisplay($expected_display);

    // The content of the file may vary depending on the Drupal version. So that
    // we assert specific parts of that file.
    $generated_content = $this->getGeneratedContent('.phpstorm.meta.php');

    self::assertServices($generated_content);
    self::assertPlugins($generated_content);
    self::assertEntityStorages($generated_content);
    self::assertEntityViewBuilders($generated_content);
    self::assertEntityListBuilders($generated_content);
    self::assertControlHandlers($generated_content);
    self::assertEntityStaticMethods($generated_content);
    self::assertOther($generated_content);
    self::assertRoutes($generated_content);
    self::assertConfigs($generated_content);
    self::assertFields($generated_content);
  }

  private static function assertServices(string $generated_content): void {
    $services_1 = <<< 'TXT'
    <?php /** @noinspection ALL */
    
    namespace PHPSTORM_META {
    
      override(
        \Drupal::service(0),
        map([
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    TXT;
    self::assertStringContainsString($services_1, $generated_content);

    $services_2 = <<< 'TXT'
      override(
        \Symfony\Component\DependencyInjection\ContainerInterface::get(0),
        map([
          'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
          'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
          'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
    TXT;
    self::assertStringContainsString($services_2, $generated_content);
  }

  private static function assertPlugins(string $generated_content): void {
    $plugins = <<< 'TXT'
      override(\Drupal\Core\Action\ActionManager::createInstance(), map(['' => '\Drupal\Core\Action\ActionInterface']));
      override(\Drupal\Core\Action\ActionManager::getInstance(), map(['' => '\Drupal\Core\Action\ActionInterface|bool']));
      override(\Drupal\Core\Archiver\ArchiverManager::createInstance(), map(['' => '\Drupal\Core\Archiver\ArchiverInterface']));
      override(\Drupal\Core\Archiver\ArchiverManager::getInstance(), map(['' => '\Drupal\Core\Archiver\ArchiverInterface|bool']));
      override(\Drupal\Core\Block\BlockManager::createInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface']));
      override(\Drupal\Core\Block\BlockManager::getInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface|bool']));
    TXT;
    self::assertStringContainsString($plugins, $generated_content);
  }

  private static function assertEntityStorages(string $generated_content): void {
    $entity_storages = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
        map([
          'action' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
          'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideStorage',
          'block' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
    TXT;
    self::assertStringContainsString($entity_storages, $generated_content);
  }

  private static function assertEntityViewBuilders(string $generated_content): void {
    $entity_view_builders = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
        map([
          'block' => '\Drupal\block\BlockViewBuilder',
          'block_content' => '\Drupal\block_content\BlockContentViewBuilder',
          'comment' => '\Drupal\comment\CommentViewBuilder',
    TXT;
    self::assertStringContainsString($entity_view_builders, $generated_content);
  }

  private static function assertEntityListBuilders(string $generated_content): void {
    $entity_list_builders = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
        map([
          'block' => '\Drupal\block\BlockListBuilder',
          'block_content' => '\Drupal\block_content\BlockContentListBuilder',
          'block_content_type' => '\Drupal\block_content\BlockContentTypeListBuilder',
    TXT;
    self::assertStringContainsString($entity_list_builders, $generated_content);
  }

  private static function assertControlHandlers(string $generated_content): void {
    $access_control_handlers = <<< 'TXT'
      override(
        \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
        map([
         'action' => '\Drupal\Core\Entity\EntityAccessControlHandler',
         'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideAccessControlHandler',
         'block' => '\Drupal\block\BlockAccessControlHandler',
    TXT;
    self::assertStringContainsString($access_control_handlers, $generated_content);
  }

  private static function assertEntityStaticMethods(string $generated_content): void {
    $entity_static_methods = <<< 'TXT'
      override(\Drupal\block\Entity\Block::loadMultiple(), map(['' => '\Drupal\block\Entity\Block[]']));
      override(\Drupal\block\Entity\Block::load(), map(['' => '\Drupal\block\Entity\Block']));
      override(\Drupal\block\Entity\Block::create(), map(['' => '\Drupal\block\Entity\Block']));
    TXT;
    self::assertStringContainsString($entity_static_methods, $generated_content);
  }

  private static function assertRoutes(string $generated_content): void {
    $route_names = <<< 'TXT'
      registerArgumentsSet('route_names',
        '<button>',
        '<current>',
        '<front>',
        '<nolink>',
        '<none>',
        'big_pipe.nojs',
        'block.admin_add',
        'block.admin_demo',
    TXT;
    self::assertStringContainsString($route_names, $generated_content);

    $route_arguments = <<< 'TXT'
      expectedArguments(\Symfony\Component\Routing\RouteCollection::get(), 0, argumentsSet('route_names'));
      expectedArguments(\Symfony\Component\Routing\RouteCollection::remove(), 0, argumentsSet('route_names'));
      expectedArguments(\Drupal\Core\Url::__construct(), 0, argumentsSet('route_names'));
      expectedArguments(\Drupal\Core\Url::fromRoute(), 0, argumentsSet('route_names'));
      expectedArguments(\Drupal\Core\Link::createFromRoute(), 1, argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Url::getRouteName(), argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Routing\RouteMatchInterface::getRouteName(), argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Menu\ContextualLinkInterface::getRouteName(), argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Menu\LocalActionInterface::getRouteName(), argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Menu\LocalTaskInterface::getRouteName(), argumentsSet('route_names'));
      expectedReturnValues(\Drupal\Core\Menu\MenuLinkInterface::getRouteName(), argumentsSet('route_names'));
    TXT;
    self::assertStringContainsString($route_arguments, $generated_content);
  }

  private static function assertConfigs(string $generated_content): void {
    $config_names = <<< 'TXT'
      registerArgumentsSet('config_names',
        'automated_cron.settings',
        'block.block.claro_breadcrumbs',
        'block.block.claro_content',
        'block.block.claro_help',
        'block.block.claro_local_actions',
    TXT;
    self::assertStringContainsString($config_names, $generated_content);

    $config_factory_arguments = <<< 'TXT'
      expectedArguments(\Drupal\Core\Config\ConfigFactoryInterface::get(), 0, argumentsSet('config_names'));
      expectedArguments(\Drupal\Core\Config\ConfigFactoryInterface::getEditable(), 0, argumentsSet('config_names'));
      expectedArguments(\Drupal\Core\Config\ConfigFactoryInterface::reset(), 0, argumentsSet('config_names'));
      expectedArguments(\Drupal::config(), 0, argumentsSet('config_names'));
    TXT;
    self::assertStringContainsString($config_factory_arguments, $generated_content);
  }

  private static function assertFields(string $generated_content): void {
    $file_fields = <<< 'TXT'
      registerArgumentsSet('fields_file',
        'fid',
        'uuid',
        'langcode',
        'uid',
        'filename',
        'uri',
        'filemime',
        'filesize',
        'status',
        'created',
        'changed',
      );
      expectedArguments(\Drupal\file\Entity\File::set(), 0, argumentsSet('fields_file'));
      expectedArguments(\Drupal\file\Entity\File::get(), 0, argumentsSet('fields_file'));
      expectedArguments(\Drupal\file\Entity\File::hasField(), 0, argumentsSet('fields_file'));
      expectedArguments(\Drupal\file\FileInterface::set(), 0, argumentsSet('fields_file'));
      expectedArguments(\Drupal\file\FileInterface::get(), 0, argumentsSet('fields_file'));
      expectedArguments(\Drupal\file\FileInterface::hasField(), 0, argumentsSet('fields_file'));
    TXT;
    self::assertStringContainsString($file_fields, $generated_content);
  }

  private static function assertOther(string $generated_content): void {
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
      expectedArguments(\Drupal\file\FileRepositoryInterface::file_copy(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\Drupal\file\FileRepositoryInterface::file_move(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\Drupal\file\FileRepositoryInterface::file_save_data(), 2, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\file_save_upload(), 4, argumentsSet('file_system_exists_behaviour'));
      expectedArguments(\system_retrieve_file(), 3, argumentsSet('file_system_exists_behaviour'));
    TXT;
    self::assertStringContainsString($other, $generated_content);
  }

}
