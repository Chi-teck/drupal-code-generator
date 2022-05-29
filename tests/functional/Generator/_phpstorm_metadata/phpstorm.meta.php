<?php /** @noinspection ALL */

namespace PHPSTORM_META {

  override(
    \Drupal::service(0),
    map([
      'access_arguments_resolver_factory' => '\Drupal\Core\Access\AccessArgumentsResolverFactory',
      'access_check.contact_personal' => '\Drupal\contact\Access\ContactPageAccess',
      'access_check.cron' => '\Drupal\system\Access\CronAccessCheck',
      'access_check.csrf' => '\Drupal\Core\Access\CsrfAccessCheck',
      'access_check.custom' => '\Drupal\Core\Access\CustomAccessCheck',
      'access_check.db_update' => '\Drupal\system\Access\DbUpdateAccessCheck',
      'access_check.default' => '\Drupal\Core\Access\DefaultAccessCheck',
      'access_check.entity' => '\Drupal\Core\Entity\EntityAccessCheck',
      'access_check.entity_create' => '\Drupal\Core\Entity\EntityCreateAccessCheck',
      'access_check.entity_create_any' => '\Drupal\Core\Entity\EntityCreateAnyAccessCheck',
      'access_check.entity_delete_multiple' => '\Drupal\Core\Entity\EntityDeleteMultipleAccessCheck',
      'access_check.field_ui.form_mode' => '\Drupal\field_ui\Access\FormModeAccessCheck',
      'access_check.field_ui.view_mode' => '\Drupal\field_ui\Access\ViewModeAccessCheck',
      'access_check.header.csrf' => '\Drupal\Core\Access\CsrfRequestHeaderAccessCheck',
      'access_check.node.preview' => '\Drupal\node\Access\NodePreviewAccessCheck',
      'access_check.permission' => '\Drupal\user\Access\PermissionAccessCheck',
      'access_check.theme' => '\Drupal\Core\Theme\ThemeAccessCheck',
      'access_check.update.manager_access' => '\Drupal\update\Access\UpdateManagerAccessCheck',
      'access_check.user.login_status' => '\Drupal\user\Access\LoginStatusCheck',
      'access_check.user.register' => '\Drupal\user\Access\RegisterAccessCheck',
      'access_check.user.role' => '\Drupal\user\Access\RoleAccessCheck',
      'access_manager' => '\Drupal\Core\Access\AccessManager',
      'account_switcher' => '\Drupal\Core\Session\AccountSwitcher',
      'ajax_response.attachments_processor' => '\Drupal\Core\Ajax\AjaxResponseAttachmentsProcessor',
      'ajax_response.subscriber' => '\Drupal\Core\EventSubscriber\AjaxResponseSubscriber',
      'anonymous_user_response_subscriber' => '\Drupal\Core\EventSubscriber\AnonymousUserResponseSubscriber',
      'asset.css.collection_grouper' => '\Drupal\Core\Asset\CssCollectionGrouper',
      'asset.css.collection_optimizer' => '\Drupal\Core\Asset\CssCollectionOptimizer',
      'asset.css.collection_renderer' => '\Drupal\Core\Asset\CssCollectionRenderer',
      'asset.css.dumper' => '\Drupal\Core\Asset\AssetDumper',
      'asset.css.optimizer' => '\Drupal\Core\Asset\CssOptimizer',
      'asset.js.collection_grouper' => '\Drupal\Core\Asset\JsCollectionGrouper',
      'asset.js.collection_optimizer' => '\Drupal\Core\Asset\JsCollectionOptimizer',
      'asset.js.collection_renderer' => '\Drupal\Core\Asset\JsCollectionRenderer',
      'asset.js.dumper' => '\Drupal\Core\Asset\AssetDumper',
      'asset.js.optimizer' => '\Drupal\Core\Asset\JsOptimizer',
      'asset.resolver' => '\Drupal\Core\Asset\AssetResolver',
      'authentication' => '\Drupal\Core\Authentication\AuthenticationManager',
      'authentication_collector' => '\Drupal\Core\Authentication\AuthenticationCollector',
      'authentication_subscriber' => '\Drupal\Core\EventSubscriber\AuthenticationSubscriber',
      'automated_cron.subscriber' => '\Drupal\automated_cron\EventSubscriber\AutomatedCron',
      'bare_html_page_renderer' => '\Drupal\Core\ProxyClass\Render\BareHtmlPageRenderer',
      'batch.storage' => '\Drupal\Core\ProxyClass\Batch\BatchStorage',
      'block.page_display_variant_subscriber' => '\Drupal\block\EventSubscriber\BlockPageDisplayVariantSubscriber',
      'block.repository' => '\Drupal\block\BlockRepository',
      'block_content.uuid_lookup' => '\Drupal\block_content\BlockContentUuidLookup',
      'breadcrumb' => '\Drupal\Core\Breadcrumb\BreadcrumbManager',
      'breakpoint.manager' => '\Drupal\breakpoint\BreakpointManager',
      'cache.backend.apcu' => '\Drupal\Core\Cache\ApcuBackendFactory',
      'cache.backend.chainedfast' => '\Drupal\Core\Cache\ChainedFastBackendFactory',
      'cache.backend.database' => '\Drupal\Core\Cache\DatabaseBackendFactory',
      'cache.backend.memory' => '\Drupal\Core\Cache\MemoryBackendFactory',
      'cache.backend.null' => '\Drupal\Core\Cache\NullBackendFactory',
      'cache.backend.php' => '\Drupal\Core\Cache\PhpBackendFactory',
      'cache.bootstrap' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.config' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.data' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.default' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.discovery' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.dynamic_page_cache' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.entity' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.menu' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.page' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.render' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.static' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache.toolbar' => '\Drupal\Core\Cache\CacheBackendInterface',
      'cache_context.cookies' => '\Drupal\Core\Cache\Context\CookiesCacheContext',
      'cache_context.headers' => '\Drupal\Core\Cache\Context\HeadersCacheContext',
      'cache_context.ip' => '\Drupal\Core\Cache\Context\IpCacheContext',
      'cache_context.languages' => '\Drupal\Core\Cache\Context\LanguagesCacheContext',
      'cache_context.protocol_version' => '\Drupal\Core\Cache\Context\ProtocolVersionCacheContext',
      'cache_context.request_format' => '\Drupal\Core\Cache\Context\RequestFormatCacheContext',
      'cache_context.route' => '\Drupal\Core\Cache\Context\RouteCacheContext',
      'cache_context.route.menu_active_trails' => '\Drupal\Core\Cache\Context\MenuActiveTrailsCacheContext',
      'cache_context.route.name' => '\Drupal\Core\Cache\Context\RouteNameCacheContext',
      'cache_context.session' => '\Drupal\Core\Cache\Context\SessionCacheContext',
      'cache_context.session.exists' => '\Drupal\Core\Cache\Context\SessionExistsCacheContext',
      'cache_context.theme' => '\Drupal\Core\Cache\Context\ThemeCacheContext',
      'cache_context.timezone' => '\Drupal\Core\Cache\Context\TimeZoneCacheContext',
      'cache_context.url' => '\Drupal\Core\Cache\Context\UrlCacheContext',
      'cache_context.url.path' => '\Drupal\Core\Cache\Context\PathCacheContext',
      'cache_context.url.path.is_front' => '\Drupal\Core\Cache\Context\IsFrontPathCacheContext',
      'cache_context.url.path.parent' => '\Drupal\Core\Cache\Context\PathParentCacheContext',
      'cache_context.url.query_args' => '\Drupal\Core\Cache\Context\QueryArgsCacheContext',
      'cache_context.url.query_args.pagers' => '\Drupal\Core\Cache\Context\PagersCacheContext',
      'cache_context.url.site' => '\Drupal\Core\Cache\Context\SiteCacheContext',
      'cache_context.user' => '\Drupal\Core\Cache\Context\UserCacheContext',
      'cache_context.user.is_super_user' => '\Drupal\Core\Cache\Context\IsSuperUserCacheContext',
      'cache_context.user.node_grants' => '\Drupal\node\Cache\NodeAccessGrantsCacheContext',
      'cache_context.user.permissions' => '\Drupal\Core\Cache\Context\AccountPermissionsCacheContext',
      'cache_context.user.roles' => '\Drupal\Core\Cache\Context\UserRolesCacheContext',
      'cache_contexts_manager' => '\Drupal\Core\Cache\Context\CacheContextsManager',
      'cache_factory' => '\Drupal\Core\Cache\CacheFactory',
      'cache_router_rebuild_subscriber' => '\Drupal\Core\EventSubscriber\CacheRouterRebuildSubscriber',
      'cache_tags.invalidator' => '\Drupal\Core\Cache\CacheTagsInvalidator',
      'cache_tags.invalidator.checksum' => '\Drupal\Core\Cache\DatabaseCacheTagsChecksum',
      'class_resolver' => '\Drupal\Core\DependencyInjection\ClassResolver',
      'client_error_response_subscriber' => '\Drupal\Core\EventSubscriber\ClientErrorResponseSubscriber',
      'comment.breadcrumb' => '\Drupal\comment\CommentBreadcrumbBuilder',
      'comment.lazy_builders' => '\Drupal\comment\CommentLazyBuilders',
      'comment.link_builder' => '\Drupal\comment\CommentLinkBuilder',
      'comment.manager' => '\Drupal\comment\CommentManager',
      'comment.statistics' => '\Drupal\comment\CommentStatistics',
      'config.config_subscriber' => '\Drupal\config\ConfigSubscriber',
      'config.factory' => '\Drupal\Core\Config\ConfigFactory',
      'config.import_transformer' => '\Drupal\Core\Config\ImportStorageTransformer',
      'config.importer_subscriber' => '\Drupal\Core\Config\Importer\FinalMissingContentSubscriber',
      'config.installer' => '\Drupal\Core\ProxyClass\Config\ConfigInstaller',
      'config.manager' => '\Drupal\Core\Config\ConfigManager',
      'config.storage' => '\Drupal\Core\Config\CachedStorage',
      'config.storage.export' => '\Drupal\Core\Config\ManagedStorage',
      'config.storage.schema' => '\Drupal\Core\Config\ExtensionInstallStorage',
      'config.storage.snapshot' => '\Drupal\Core\Config\DatabaseStorage',
      'config.storage.sync' => '\Drupal\Core\Config\FileStorage',
      'config.typed' => '\Drupal\Core\Config\TypedConfigManager',
      'config_exclude_modules_subscriber' => '\Drupal\Core\EventSubscriber\ExcludedModulesEventSubscriber',
      'config_import_subscriber' => '\Drupal\Core\EventSubscriber\ConfigImportSubscriber',
      'config_snapshot_subscriber' => '\Drupal\Core\EventSubscriber\ConfigSnapshotSubscriber',
      'contact.mail_handler' => '\Drupal\contact\MailHandler',
      'container.namespaces' => '\ArrayObject',
      'content_type_header_matcher' => '\Drupal\Core\Routing\ContentTypeHeaderMatcher',
      'content_uninstall_validator' => '\Drupal\Core\ProxyClass\Entity\ContentUninstallValidator',
      'context.handler' => '\Drupal\Core\Plugin\Context\ContextHandler',
      'context.repository' => '\Drupal\Core\Plugin\Context\LazyContextRepository',
      'controller.entity_form' => '\Drupal\Core\Entity\HtmlEntityFormController',
      'controller.form' => '\Drupal\Core\Controller\HtmlFormController',
      'controller_resolver' => '\Drupal\Core\Controller\ControllerResolver',
      'country_manager' => '\Drupal\Core\Locale\CountryManager',
      'cron' => '\Drupal\Core\ProxyClass\Cron',
      'csrf_token' => '\Drupal\Core\Access\CsrfTokenGenerator',
      'current_route_match' => '\Drupal\Core\Routing\CurrentRouteMatch',
      'current_user' => '\Drupal\Core\Session\AccountProxy',
      'database' => '\Drupal\Core\Database\Connection',
      'database.replica' => '\Drupal\Core\Database\Connection',
      'database.replica_kill_switch' => '\Drupal\Core\Database\ReplicaKillSwitch',
      'database_driver_uninstall_validator' => '\Drupal\Core\ProxyClass\Extension\DatabaseDriverUninstallValidator',
      'date.formatter' => '\Drupal\Core\Datetime\DateFormatter',
      'datetime.time' => '\Drupal\Component\Datetime\Time',
      'diff.formatter' => '\Drupal\Core\Diff\DiffFormatter',
      'drupal.proxy_original_service.bare_html_page_renderer' => '\Drupal\Core\Render\BareHtmlPageRenderer',
      'drupal.proxy_original_service.batch.storage' => '\Drupal\Core\Batch\BatchStorage',
      'drupal.proxy_original_service.config.installer' => '\Drupal\Core\Config\ConfigInstaller',
      'drupal.proxy_original_service.content_uninstall_validator' => '\Drupal\Core\Entity\ContentUninstallValidator',
      'drupal.proxy_original_service.cron' => '\Drupal\Core\Cron',
      'drupal.proxy_original_service.database_driver_uninstall_validator' => '\Drupal\Core\Extension\DatabaseDriverUninstallValidator',
      'drupal.proxy_original_service.dynamic_page_cache_response_policy' => '\Drupal\Core\PageCache\ChainResponsePolicy',
      'drupal.proxy_original_service.field.uninstall_validator' => '\Drupal\field\FieldUninstallValidator',
      'drupal.proxy_original_service.file.mime_type.guesser' => '\Drupal\Core\File\MimeType\MimeTypeGuesser',
      'drupal.proxy_original_service.file.mime_type.guesser.extension' => '\Drupal\Core\File\MimeType\ExtensionMimeTypeGuesser',
      'drupal.proxy_original_service.filter.uninstall_validator' => '\Drupal\filter\FilterUninstallValidator',
      'drupal.proxy_original_service.lock' => '\Drupal\Core\Lock\DatabaseLockBackend',
      'drupal.proxy_original_service.lock.persistent' => '\Drupal\Core\Lock\PersistentDatabaseLockBackend',
      'drupal.proxy_original_service.module_installer' => '\Drupal\Core\Extension\ModuleInstaller',
      'drupal.proxy_original_service.module_required_by_themes_uninstall_validator' => '\Drupal\Core\Extension\ModuleRequiredByThemesUninstallValidator',
      'drupal.proxy_original_service.node_preview' => '\Drupal\node\ParamConverter\NodePreviewConverter',
      'drupal.proxy_original_service.page_cache_response_policy' => '\Drupal\Core\PageCache\ChainResponsePolicy',
      'drupal.proxy_original_service.paramconverter.configentity_admin' => '\Drupal\Core\ParamConverter\AdminPathConfigEntityConverter',
      'drupal.proxy_original_service.paramconverter.menu_link' => '\Drupal\Core\ParamConverter\MenuLinkPluginConverter',
      'drupal.proxy_original_service.paramconverter.views_ui' => '\Drupal\views_ui\ParamConverter\ViewUIConverter',
      'drupal.proxy_original_service.plugin.cache_clearer' => '\Drupal\Core\Plugin\CachedDiscoveryClearer',
      'drupal.proxy_original_service.required_module_uninstall_validator' => '\Drupal\Core\Extension\RequiredModuleUninstallValidator',
      'drupal.proxy_original_service.router.builder' => '\Drupal\Core\Routing\RouteBuilder',
      'drupal.proxy_original_service.router.dumper' => '\Drupal\Core\Routing\MatcherDumper',
      'dynamic_page_cache_request_policy' => '\Drupal\dynamic_page_cache\PageCache\RequestPolicy\DefaultRequestPolicy',
      'dynamic_page_cache_response_policy' => '\Drupal\Core\ProxyClass\PageCache\ChainResponsePolicy',
      'dynamic_page_cache_subscriber' => '\Drupal\dynamic_page_cache\EventSubscriber\DynamicPageCacheSubscriber',
      'early_rendering_controller_wrapper_subscriber' => '\Drupal\Core\EventSubscriber\EarlyRenderingControllerWrapperSubscriber',
      'editor.config_translation_mapper_subscriber' => '\Drupal\editor\EventSubscriber\EditorConfigTranslationSubscriber',
      'element.editor' => '\Drupal\editor\Element',
      'email.validator' => '\Drupal\Component\Utility\EmailValidator',
      'entity.autocomplete_matcher' => '\Drupal\Core\Entity\EntityAutocompleteMatcher',
      'entity.bundle_config_import_validator' => '\Drupal\Core\Entity\Event\BundleConfigImportValidate',
      'entity.definition_update_manager' => '\Drupal\Core\Entity\EntityDefinitionUpdateManager',
      'entity.form_builder' => '\Drupal\Core\Entity\EntityFormBuilder',
      'entity.last_installed_schema.repository' => '\Drupal\Core\Entity\EntityLastInstalledSchemaRepository',
      'entity.memory_cache' => '\Drupal\Core\Cache\MemoryCache\MemoryCache',
      'entity.query.config' => '\Drupal\Core\Config\Entity\Query\QueryFactory',
      'entity.query.keyvalue' => '\Drupal\Core\Entity\KeyValueStore\Query\QueryFactory',
      'entity.query.null' => '\Drupal\Core\Entity\Query\Null\QueryFactory',
      'entity.query.sql' => '\Drupal\Core\Entity\Query\Sql\QueryFactory',
      'entity.repository' => '\Drupal\Core\Entity\EntityRepository',
      'entity_bundle.listener' => '\Drupal\Core\Entity\EntityBundleListener',
      'entity_display.repository' => '\Drupal\Core\Entity\EntityDisplayRepository',
      'entity_field.deleted_fields_repository' => '\Drupal\Core\Field\DeletedFieldsRepository',
      'entity_field.manager' => '\Drupal\Core\Entity\EntityFieldManager',
      'entity_route_subscriber' => '\Drupal\Core\EventSubscriber\EntityRouteProviderSubscriber',
      'entity_type.bundle.info' => '\Drupal\Core\Entity\EntityTypeBundleInfo',
      'entity_type.listener' => '\Drupal\Core\Entity\EntityTypeListener',
      'entity_type.manager' => '\Drupal\Core\Entity\EntityTypeManager',
      'entity_type.repository' => '\Drupal\Core\Entity\EntityTypeRepository',
      'event_dispatcher' => '\Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher',
      'exception.custom_page_html' => '\Drupal\Core\EventSubscriber\CustomPageExceptionHtmlSubscriber',
      'exception.default_html' => '\Drupal\Core\EventSubscriber\DefaultExceptionHtmlSubscriber',
      'exception.default_json' => '\Drupal\Core\EventSubscriber\ExceptionJsonSubscriber',
      'exception.enforced_form_response' => '\Drupal\Core\EventSubscriber\EnforcedFormResponseSubscriber',
      'exception.fast_404_html' => '\Drupal\Core\EventSubscriber\Fast404ExceptionHtmlSubscriber',
      'exception.final' => '\Drupal\Core\EventSubscriber\FinalExceptionSubscriber',
      'exception.logger' => '\Drupal\Core\EventSubscriber\ExceptionLoggingSubscriber',
      'exception.needs_installer' => '\Drupal\Core\EventSubscriber\ExceptionDetectNeedsInstallSubscriber',
      'exception.test_site' => '\Drupal\Core\EventSubscriber\ExceptionTestSiteSubscriber',
      'extension.list.module' => '\Drupal\Core\Extension\ModuleExtensionList',
      'extension.list.profile' => '\Drupal\Core\Extension\ProfileExtensionList',
      'extension.list.theme' => '\Drupal\Core\Extension\ThemeExtensionList',
      'extension.list.theme_engine' => '\Drupal\Core\Extension\ThemeEngineExtensionList',
      'extension.path.resolver' => '\Drupal\Core\Extension\ExtensionPathResolver',
      'field.uninstall_validator' => '\Drupal\field\ProxyClass\FieldUninstallValidator',
      'field_definition.listener' => '\Drupal\Core\Field\FieldDefinitionListener',
      'field_storage_definition.listener' => '\Drupal\Core\Field\FieldStorageDefinitionListener',
      'field_ui.subscriber' => '\Drupal\field_ui\Routing\RouteSubscriber',
      'file.htaccess_writer' => '\Drupal\Core\File\HtaccessWriter',
      'file.mime_type.guesser' => '\Drupal\Core\ProxyClass\File\MimeType\MimeTypeGuesser',
      'file.mime_type.guesser.extension' => '\Drupal\Core\ProxyClass\File\MimeType\ExtensionMimeTypeGuesser',
      'file.repository' => '\Drupal\file\FileRepository',
      'file.upload_handler' => '\Drupal\file\Upload\FileUploadHandler',
      'file.usage' => '\Drupal\file\FileUsage\DatabaseFileUsageBackend',
      'file_system' => '\Drupal\Core\File\FileSystem',
      'file_url_generator' => '\Drupal\Core\File\FileUrlGenerator',
      'filter.uninstall_validator' => '\Drupal\filter\ProxyClass\FilterUninstallValidator',
      'finish_response_subscriber' => '\Drupal\Core\EventSubscriber\FinishResponseSubscriber',
      'flood' => '\Drupal\Core\Flood\DatabaseBackend',
      'form_ajax_response_builder' => '\Drupal\Core\Form\FormAjaxResponseBuilder',
      'form_ajax_subscriber' => '\Drupal\Core\Form\EventSubscriber\FormAjaxSubscriber',
      'form_builder' => '\Drupal\Core\Form\FormBuilder',
      'form_error_handler' => '\Drupal\Core\Form\FormErrorHandler',
      'form_submitter' => '\Drupal\Core\Form\FormSubmitter',
      'form_validator' => '\Drupal\Core\Form\FormValidator',
      'html_response.attachments_processor' => '\Drupal\Core\Render\HtmlResponseAttachmentsProcessor',
      'html_response.placeholder_strategy_subscriber' => '\Drupal\Core\EventSubscriber\HtmlResponsePlaceholderStrategySubscriber',
      'html_response.subscriber' => '\Drupal\Core\EventSubscriber\HtmlResponseSubscriber',
      'http_client' => '\GuzzleHttp\Client',
      'http_client_factory' => '\Drupal\Core\Http\ClientFactory',
      'http_kernel' => '\Drupal\Core\StackMiddleware\StackedHttpKernel',
      'http_kernel.basic' => '\Symfony\Component\HttpKernel\HttpKernel',
      'http_kernel.controller.argument_resolver' => '\Symfony\Component\HttpKernel\Controller\ArgumentResolver',
      'http_middleware.kernel_pre_handle' => '\Drupal\Core\StackMiddleware\KernelPreHandle',
      'http_middleware.negotiation' => '\Drupal\Core\StackMiddleware\NegotiationMiddleware',
      'http_middleware.page_cache' => '\Drupal\page_cache\StackMiddleware\PageCache',
      'http_middleware.reverse_proxy' => '\Drupal\Core\StackMiddleware\ReverseProxyMiddleware',
      'http_middleware.session' => '\Drupal\Core\StackMiddleware\Session',
      'image.factory' => '\Drupal\Core\Image\ImageFactory',
      'image.toolkit.manager' => '\Drupal\Core\ImageToolkit\ImageToolkitManager',
      'image.toolkit.operation.manager' => '\Drupal\Core\ImageToolkit\ImageToolkitOperationManager',
      'info_parser' => '\Drupal\Core\Extension\InfoParser',
      'kernel' => '\Symfony\Component\HttpKernel\KernelInterface',
      'kernel_destruct_subscriber' => '\Drupal\Core\EventSubscriber\KernelDestructionSubscriber',
      'keyvalue' => '\Drupal\Core\KeyValueStore\KeyValueFactory',
      'keyvalue.database' => '\Drupal\Core\KeyValueStore\KeyValueDatabaseFactory',
      'keyvalue.expirable' => '\Drupal\Core\KeyValueStore\KeyValueExpirableFactory',
      'keyvalue.expirable.database' => '\Drupal\Core\KeyValueStore\KeyValueDatabaseExpirableFactory',
      'language.current_language_context' => '\Drupal\Core\Language\ContextProvider\CurrentLanguageContext',
      'language.default' => '\Drupal\Core\Language\LanguageDefault',
      'language_manager' => '\Drupal\Core\Language\LanguageManager',
      'library.dependency_resolver' => '\Drupal\Core\Asset\LibraryDependencyResolver',
      'library.discovery' => '\Drupal\Core\Asset\LibraryDiscovery',
      'library.discovery.collector' => '\Drupal\Core\Asset\LibraryDiscoveryCollector',
      'library.discovery.parser' => '\Drupal\Core\Asset\LibraryDiscoveryParser',
      'library.libraries_directory_file_finder' => '\Drupal\Core\Asset\LibrariesDirectoryFileFinder',
      'link_generator' => '\Drupal\Core\Utility\LinkGenerator',
      'lock' => '\Drupal\Core\ProxyClass\Lock\DatabaseLockBackend',
      'lock.persistent' => '\Drupal\Core\ProxyClass\Lock\PersistentDatabaseLockBackend',
      'logger.channel.contact' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.cron' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.default' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.file' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.form' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.image' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.php' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.security' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.system' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.channel.user' => '\Drupal\Core\Logger\LoggerChannel',
      'logger.dblog' => '\Drupal\dblog\Logger\DbLog',
      'logger.factory' => '\Drupal\Core\Logger\LoggerChannelFactory',
      'logger.log_message_parser' => '\Drupal\Core\Logger\LogMessageParser',
      'main_content_renderer.ajax' => '\Drupal\Core\Render\MainContent\AjaxRenderer',
      'main_content_renderer.dialog' => '\Drupal\Core\Render\MainContent\DialogRenderer',
      'main_content_renderer.html' => '\Drupal\Core\Render\MainContent\HtmlRenderer',
      'main_content_renderer.modal' => '\Drupal\Core\Render\MainContent\ModalRenderer',
      'main_content_renderer.off_canvas' => '\Drupal\Core\Render\MainContent\OffCanvasRenderer',
      'main_content_renderer.off_canvas_top' => '\Drupal\Core\Render\MainContent\OffCanvasRenderer',
      'main_content_view_subscriber' => '\Drupal\Core\EventSubscriber\MainContentViewSubscriber',
      'maintenance_mode' => '\Drupal\Core\Site\MaintenanceMode',
      'maintenance_mode_subscriber' => '\Drupal\Core\EventSubscriber\MaintenanceModeSubscriber',
      'menu.active_trail' => '\Drupal\Core\Menu\MenuActiveTrail',
      'menu.default_tree_manipulators' => '\Drupal\Core\Menu\DefaultMenuLinkTreeManipulators',
      'menu.link_tree' => '\Drupal\Core\Menu\MenuLinkTree',
      'menu.parent_form_selector' => '\Drupal\Core\Menu\MenuParentFormSelector',
      'menu.rebuild_subscriber' => '\Drupal\Core\EventSubscriber\MenuRouterRebuildSubscriber',
      'menu_link.static.overrides' => '\Drupal\Core\Menu\StaticMenuLinkOverrides',
      'messenger' => '\Drupal\Core\Messenger\Messenger',
      'method_filter' => '\Drupal\Core\Routing\MethodFilter',
      'module_handler' => '\Drupal\Core\Extension\ModuleHandler',
      'module_installer' => '\Drupal\Core\ProxyClass\Extension\ModuleInstaller',
      'module_required_by_themes_uninstall_validator' => '\Drupal\Core\ProxyClass\Extension\ModuleRequiredByThemesUninstallValidator',
      'node.admin_path.route_subscriber' => '\Drupal\node\EventSubscriber\NodeAdminRouteSubscriber',
      'node.grant_storage' => '\Drupal\node\NodeGrantDatabaseStorage',
      'node.node_route_context' => '\Drupal\node\ContextProvider\NodeRouteContext',
      'node.route_subscriber' => '\Drupal\node\Routing\RouteSubscriber',
      'node_preview' => '\Drupal\node\ProxyClass\ParamConverter\NodePreviewConverter',
      'options_request_listener' => '\Drupal\Core\EventSubscriber\OptionsRequestSubscriber',
      'page_cache_kill_switch' => '\Drupal\Core\PageCache\ResponsePolicy\KillSwitch',
      'page_cache_request_policy' => '\Drupal\Core\PageCache\DefaultRequestPolicy',
      'page_cache_response_policy' => '\Drupal\Core\ProxyClass\PageCache\ChainResponsePolicy',
      'pager.manager' => '\Drupal\Core\Pager\PagerManager',
      'pager.parameters' => '\Drupal\Core\Pager\PagerParameters',
      'paramconverter.configentity_admin' => '\Drupal\Core\ProxyClass\ParamConverter\AdminPathConfigEntityConverter',
      'paramconverter.entity' => '\Drupal\Core\ParamConverter\EntityConverter',
      'paramconverter.entity_revision' => '\Drupal\Core\ParamConverter\EntityRevisionParamConverter',
      'paramconverter.menu_link' => '\Drupal\Core\ProxyClass\ParamConverter\MenuLinkPluginConverter',
      'paramconverter.views_ui' => '\Drupal\views_ui\ProxyClass\ParamConverter\ViewUIConverter',
      'paramconverter_manager' => '\Drupal\Core\ParamConverter\ParamConverterManager',
      'paramconverter_subscriber' => '\Drupal\Core\EventSubscriber\ParamConverterSubscriber',
      'password' => '\Drupal\Core\Password\PhpassHashedPassword',
      'password_generator' => '\Drupal\Core\Password\DefaultPasswordGenerator',
      'path.current' => '\Drupal\Core\Path\CurrentPathStack',
      'path.matcher' => '\Drupal\Core\Path\PathMatcher',
      'path.validator' => '\Drupal\Core\Path\PathValidator',
      'path_alias.manager' => '\Drupal\path_alias\AliasManager',
      'path_alias.path_processor' => '\Drupal\path_alias\PathProcessor\AliasPathProcessor',
      'path_alias.repository' => '\Drupal\path_alias\AliasRepository',
      'path_alias.subscriber' => '\Drupal\path_alias\EventSubscriber\PathAliasSubscriber',
      'path_alias.whitelist' => '\Drupal\path_alias\AliasWhitelist',
      'path_processor.files' => '\Drupal\system\PathProcessor\PathProcessorFiles',
      'path_processor.image_styles' => '\Drupal\image\PathProcessor\PathProcessorImageStyles',
      'path_processor_decode' => '\Drupal\Core\PathProcessor\PathProcessorDecode',
      'path_processor_front' => '\Drupal\Core\PathProcessor\PathProcessorFront',
      'path_processor_manager' => '\Drupal\Core\PathProcessor\PathProcessorManager',
      'pgsql.entity.query.sql' => '\Drupal\Core\Entity\Query\Sql\pgsql\QueryFactory',
      'placeholder_strategy' => '\Drupal\Core\Render\Placeholder\ChainedPlaceholderStrategy',
      'placeholder_strategy.single_flush' => '\Drupal\Core\Render\Placeholder\SingleFlushStrategy',
      'plugin.cache_clearer' => '\Drupal\Core\ProxyClass\Plugin\CachedDiscoveryClearer',
      'plugin.manager.action' => '\Drupal\Core\Action\ActionManager',
      'plugin.manager.archiver' => '\Drupal\Core\Archiver\ArchiverManager',
      'plugin.manager.block' => '\Drupal\Core\Block\BlockManager',
      'plugin.manager.ckeditor.plugin' => '\Drupal\ckeditor\CKEditorPluginManager',
      'plugin.manager.condition' => '\Drupal\Core\Condition\ConditionManager',
      'plugin.manager.display_variant' => '\Drupal\Core\Display\VariantManager',
      'plugin.manager.editor' => '\Drupal\editor\Plugin\EditorManager',
      'plugin.manager.element_info' => '\Drupal\Core\Render\ElementInfoManager',
      'plugin.manager.entity_reference_selection' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager',
      'plugin.manager.field.field_type' => '\Drupal\Core\Field\FieldTypePluginManager',
      'plugin.manager.field.formatter' => '\Drupal\Core\Field\FormatterPluginManager',
      'plugin.manager.field.widget' => '\Drupal\Core\Field\WidgetPluginManager',
      'plugin.manager.filter' => '\Drupal\filter\FilterPluginManager',
      'plugin.manager.help_section' => '\Drupal\help\HelpSectionManager',
      'plugin.manager.image.effect' => '\Drupal\image\ImageEffectManager',
      'plugin.manager.link_relation_type' => '\Drupal\Core\Http\LinkRelationTypeManager',
      'plugin.manager.mail' => '\Drupal\Core\Mail\MailManager',
      'plugin.manager.menu.contextual_link' => '\Drupal\Core\Menu\ContextualLinkManager',
      'plugin.manager.menu.link' => '\Drupal\Core\Menu\MenuLinkManager',
      'plugin.manager.menu.local_action' => '\Drupal\Core\Menu\LocalActionManager',
      'plugin.manager.menu.local_task' => '\Drupal\Core\Menu\LocalTaskManager',
      'plugin.manager.queue_worker' => '\Drupal\Core\Queue\QueueWorkerManager',
      'plugin.manager.search' => '\Drupal\search\SearchPluginManager',
      'plugin.manager.tour.tip' => '\Drupal\tour\TipPluginManager',
      'plugin.manager.views.access' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.area' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.argument' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.argument_default' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.argument_validator' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.cache' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.display' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.display_extender' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.exposed_form' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.field' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.filter' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.join' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.pager' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.query' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.relationship' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.row' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.sort' => '\Drupal\views\Plugin\ViewsHandlerManager',
      'plugin.manager.views.style' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin.manager.views.wizard' => '\Drupal\views\Plugin\ViewsPluginManager',
      'plugin_form.factory' => '\Drupal\Core\Plugin\PluginFormFactory',
      'private_key' => '\Drupal\Core\PrivateKey',
      'psr7.http_foundation_factory' => '\Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory',
      'psr7.http_message_factory' => '\Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory',
      'psr_response_view_subscriber' => '\Drupal\Core\EventSubscriber\PsrResponseSubscriber',
      'queue' => '\Drupal\Core\Queue\QueueFactory',
      'queue.database' => '\Drupal\Core\Queue\QueueDatabaseFactory',
      'redirect.destination' => '\Drupal\Core\Routing\RedirectDestination',
      'redirect_leading_slashes_subscriber' => '\Drupal\Core\EventSubscriber\RedirectLeadingSlashesSubscriber',
      'redirect_response_subscriber' => '\Drupal\Core\EventSubscriber\RedirectResponseSubscriber',
      'render_cache' => '\Drupal\Core\Render\PlaceholderingRenderCache',
      'render_placeholder_generator' => '\Drupal\Core\Render\PlaceholderGenerator',
      'renderer' => '\Drupal\Core\Render\Renderer',
      'renderer_non_html' => '\Drupal\Core\EventSubscriber\RenderArrayNonHtmlSubscriber',
      'request_close_subscriber' => '\Drupal\Core\EventSubscriber\RequestCloseSubscriber',
      'request_format_route_filter' => '\Drupal\Core\Routing\RequestFormatRouteFilter',
      'request_stack' => '\Symfony\Component\HttpFoundation\RequestStack',
      'required_module_uninstall_validator' => '\Drupal\Core\ProxyClass\Extension\RequiredModuleUninstallValidator',
      'resolver_manager.entity' => '\Drupal\Core\Entity\EntityResolverManager',
      'response_filter.active_link' => '\Drupal\Core\EventSubscriber\ActiveLinkResponseFilter',
      'response_filter.rss.relative_url' => '\Drupal\Core\EventSubscriber\RssResponseRelativeUrlFilter',
      'response_generator_subscriber' => '\Drupal\Core\EventSubscriber\ResponseGeneratorSubscriber',
      'route_access_response_subscriber' => '\Drupal\Core\EventSubscriber\RouteAccessResponseSubscriber',
      'route_enhancer.entity' => '\Drupal\Core\Entity\Enhancer\EntityRouteEnhancer',
      'route_enhancer.entity_bundle' => '\Drupal\Core\Entity\Enhancer\EntityBundleRouteEnhancer',
      'route_enhancer.entity_revision' => '\Drupal\Core\Routing\Enhancer\EntityRevisionRouteEnhancer',
      'route_enhancer.form' => '\Drupal\Core\Routing\Enhancer\FormRouteEnhancer',
      'route_enhancer.param_conversion' => '\Drupal\Core\Routing\Enhancer\ParamConversionEnhancer',
      'route_http_method_subscriber' => '\Drupal\Core\EventSubscriber\RouteMethodSubscriber',
      'route_processor_csrf' => '\Drupal\Core\Access\RouteProcessorCsrf',
      'route_processor_current' => '\Drupal\Core\RouteProcessor\RouteProcessorCurrent',
      'route_processor_manager' => '\Drupal\Core\RouteProcessor\RouteProcessorManager',
      'route_special_attributes_subscriber' => '\Drupal\Core\EventSubscriber\SpecialAttributesRouteSubscriber',
      'route_subscriber.entity' => '\Drupal\Core\EventSubscriber\EntityRouteAlterSubscriber',
      'route_subscriber.module' => '\Drupal\Core\EventSubscriber\ModuleRouteSubscriber',
      'router' => '\Drupal\Core\Routing\AccessAwareRouter',
      'router.admin_context' => '\Drupal\Core\Routing\AdminContext',
      'router.builder' => '\Drupal\Core\ProxyClass\Routing\RouteBuilder',
      'router.dumper' => '\Drupal\Core\ProxyClass\Routing\MatcherDumper',
      'router.no_access_checks' => '\Drupal\Core\Routing\Router',
      'router.path_roots_subscriber' => '\Drupal\Core\EventSubscriber\PathRootsSubscriber',
      'router.request_context' => '\Drupal\Core\Routing\RequestContext',
      'router.route_preloader' => '\Drupal\Core\Routing\RoutePreloader',
      'router.route_provider' => '\Drupal\Core\Routing\RouteProvider',
      'router.route_provider.lazy_builder' => '\Drupal\Core\Routing\RouteProviderLazyBuilder',
      'router_listener' => '\Symfony\Component\HttpKernel\EventListener\RouterListener',
      'search.index' => '\Drupal\search\SearchIndex',
      'search.search_page_repository' => '\Drupal\search\SearchPageRepository',
      'search.text_processor' => '\Drupal\search\SearchTextProcessor',
      'serialization.json' => '\Drupal\Component\Serialization\Json',
      'serialization.phpserialize' => '\Drupal\Component\Serialization\PhpSerialize',
      'serialization.yaml' => '\Drupal\Component\Serialization\Yaml',
      'service_container' => '\Symfony\Component\DependencyInjection\ContainerInterface',
      'session' => '\Symfony\Component\HttpFoundation\Session\Session',
      'session_configuration' => '\Drupal\Core\Session\SessionConfiguration',
      'session_handler.storage' => '\Drupal\Core\Session\SessionHandler',
      'session_handler.write_safe' => '\Drupal\Core\Session\WriteSafeSessionHandler',
      'session_manager' => '\Drupal\Core\Session\SessionManager',
      'session_manager.metadata_bag' => '\Drupal\Core\Session\MetadataBag',
      'settings' => '\Drupal\Core\Site\Settings',
      'shortcut.lazy_builders' => '\Drupal\shortcut\ShortcutLazyBuilders',
      'state' => '\Drupal\Core\State\State',
      'stream_wrapper.public' => '\Drupal\Core\StreamWrapper\PublicStream',
      'stream_wrapper.temporary' => '\Drupal\Core\StreamWrapper\TemporaryStream',
      'stream_wrapper_manager' => '\Drupal\Core\StreamWrapper\StreamWrapperManager',
      'string_translation' => '\Drupal\Core\StringTranslation\TranslationManager',
      'string_translator.custom_strings' => '\Drupal\Core\StringTranslation\Translator\CustomStrings',
      'system.admin_path.route_subscriber' => '\Drupal\system\EventSubscriber\AdminRouteSubscriber',
      'system.advisories_config_subscriber' => '\Drupal\system\EventSubscriber\AdvisoriesConfigSubscriber',
      'system.breadcrumb.default' => '\Drupal\system\PathBasedBreadcrumbBuilder',
      'system.config_cache_tag' => '\Drupal\system\EventSubscriber\ConfigCacheTag',
      'system.config_subscriber' => '\Drupal\system\SystemConfigSubscriber',
      'system.file_event.subscriber' => '\Drupal\system\EventSubscriber\SecurityFileUploadEventSubscriber',
      'system.manager' => '\Drupal\system\SystemManager',
      'system.sa_fetcher' => '\Drupal\system\SecurityAdvisories\SecurityAdvisoriesFetcher',
      'system.timezone_resolver' => '\Drupal\system\TimeZoneResolver',
      'taxonomy_term.breadcrumb' => '\Drupal\taxonomy\TermBreadcrumbBuilder',
      'taxonomy_term.taxonomy_term_route_context' => '\Drupal\taxonomy\ContextProvider\TermRouteContext',
      'tempstore.private' => '\Drupal\Core\TempStore\PrivateTempStoreFactory',
      'tempstore.shared' => '\Drupal\Core\TempStore\SharedTempStoreFactory',
      'theme.initialization' => '\Drupal\Core\Theme\ThemeInitialization',
      'theme.manager' => '\Drupal\Core\Theme\ThemeManager',
      'theme.negotiator' => '\Drupal\Core\Theme\ThemeNegotiator',
      'theme.negotiator.admin_theme' => '\Drupal\user\Theme\AdminNegotiator',
      'theme.negotiator.ajax_base_page' => '\Drupal\Core\Theme\AjaxBasePageNegotiator',
      'theme.negotiator.block.admin_demo' => '\Drupal\block\Theme\AdminDemoNegotiator',
      'theme.negotiator.default' => '\Drupal\Core\Theme\DefaultNegotiator',
      'theme.negotiator.system.batch' => '\Drupal\system\Theme\BatchNegotiator',
      'theme.negotiator.system.db_update' => '\Drupal\system\Theme\DbUpdateNegotiator',
      'theme.registry' => '\Drupal\Core\Theme\Registry',
      'theme_handler' => '\Drupal\Core\Extension\ThemeHandler',
      'theme_installer' => '\Drupal\Core\Extension\ThemeInstaller',
      'title_resolver' => '\Drupal\Core\Controller\TitleResolver',
      'token' => '\Drupal\Core\Utility\Token',
      'toolbar.menu_tree' => '\Drupal\toolbar\Menu\ToolbarMenuLinkTree',
      'toolbar.page_cache_request_policy.allow_toolbar_path' => '\Drupal\toolbar\PageCache\AllowToolbarPath',
      'transliteration' => '\Drupal\Core\Transliteration\PhpTransliteration',
      'twig' => '\Drupal\Core\Template\TwigEnvironment',
      'twig.extension' => '\Drupal\Core\Template\TwigExtension',
      'twig.extension.debug' => '\Twig\Extension\DebugExtension',
      'twig.loader.filesystem' => '\Drupal\Core\Template\Loader\FilesystemLoader',
      'twig.loader.string' => '\Drupal\Core\Template\Loader\StringLoader',
      'twig.loader.theme_registry' => '\Drupal\Core\Template\Loader\ThemeRegistryLoader',
      'typed_data_manager' => '\Drupal\Core\TypedData\TypedDataManager',
      'unrouted_url_assembler' => '\Drupal\Core\Utility\UnroutedUrlAssembler',
      'update.fetcher' => '\Drupal\update\UpdateFetcher',
      'update.manager' => '\Drupal\update\UpdateManager',
      'update.post_update_registry' => '\Drupal\Core\Update\UpdateRegistry',
      'update.post_update_registry_factory' => '\Drupal\Core\Update\UpdateRegistryFactory',
      'update.processor' => '\Drupal\update\UpdateProcessor',
      'update.root' => '\Drupal\update\UpdateRoot',
      'update.update_hook_registry' => '\Drupal\Core\Update\UpdateHookRegistry',
      'update.update_hook_registry_factory' => '\Drupal\Core\Update\UpdateHookRegistryFactory',
      'url_generator' => '\Drupal\Core\Render\MetadataBubblingUrlGenerator',
      'user.auth' => '\Drupal\user\UserAuth',
      'user.authentication.cookie' => '\Drupal\user\Authentication\Provider\Cookie',
      'user.current_user_context' => '\Drupal\user\ContextProvider\CurrentUserContext',
      'user.data' => '\Drupal\user\UserData',
      'user.flood_control' => '\Drupal\user\UserFloodControl',
      'user.flood_subscriber' => '\Drupal\user\EventSubscriber\UserFloodSubscriber',
      'user.permissions' => '\Drupal\user\PermissionHandler',
      'user.toolbar_link_builder' => '\Drupal\user\ToolbarLinkBuilder',
      'user_access_denied_subscriber' => '\Drupal\user\EventSubscriber\AccessDeniedSubscriber',
      'user_last_access_subscriber' => '\Drupal\user\EventSubscriber\UserRequestSubscriber',
      'user_maintenance_mode_subscriber' => '\Drupal\user\EventSubscriber\MaintenanceModeSubscriber',
      'user_permissions_hash_generator' => '\Drupal\Core\Session\PermissionsHashGenerator',
      'uuid' => '\Drupal\Component\Uuid\Php',
      'validation.constraint' => '\Drupal\Core\Validation\ConstraintManager',
      'views.analyzer' => '\Drupal\views\Analyzer',
      'views.date_sql' => '\Drupal\views\Plugin\views\query\MysqlDateSql',
      'views.entity_schema_subscriber' => '\Drupal\views\EventSubscriber\ViewsEntitySchemaSubscriber',
      'views.executable' => '\Drupal\views\ViewExecutableFactory',
      'views.exposed_form_cache' => '\Drupal\views\ExposedFormCache',
      'views.route_subscriber' => '\Drupal\views\EventSubscriber\RouteSubscriber',
      'views.views_data' => '\Drupal\views\ViewsData',
      'views.views_data_helper' => '\Drupal\views\ViewsDataHelper',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
    map([
      'block' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'block_content_type' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'block_content' => '\Drupal\Core\Entity\Sql\SqlContentEntityStorage',
      'comment' => '\Drupal\comment\CommentStorage',
      'comment_type' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'contact_form' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'contact_message' => '\Drupal\Core\Entity\ContentEntityNullStorage',
      'editor' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'field_storage_config' => '\Drupal\field\FieldStorageConfigStorage',
      'field_config' => '\Drupal\field\FieldConfigStorage',
      'file' => '\Drupal\file\FileStorage',
      'filter_format' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'image_style' => '\Drupal\image\ImageStyleStorage',
      'menu_link_content' => '\Drupal\menu_link_content\MenuLinkContentStorage',
      'node_type' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'node' => '\Drupal\node\NodeStorage',
      'path_alias' => '\Drupal\path_alias\PathAliasStorage',
      'rdf_mapping' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'search_page' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'shortcut' => '\Drupal\Core\Entity\Sql\SqlContentEntityStorage',
      'shortcut_set' => '\Drupal\shortcut\ShortcutSetStorage',
      'menu' => '\Drupal\system\MenuStorage',
      'action' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'taxonomy_vocabulary' => '\Drupal\taxonomy\VocabularyStorage',
      'taxonomy_term' => '\Drupal\taxonomy\TermStorage',
      'tour' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'user_role' => '\Drupal\user\RoleStorage',
      'user' => '\Drupal\user\UserStorage',
      'view' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideStorage',
      'date_format' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'entity_form_display' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'entity_view_display' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'entity_form_mode' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
      'entity_view_mode' => '\Drupal\Core\Config\Entity\ConfigEntityStorage',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
    map([
      'block' => '\Drupal\block\BlockViewBuilder',
      'block_content' => '\Drupal\block_content\BlockContentViewBuilder',
      'comment' => '\Drupal\comment\CommentViewBuilder',
      'contact_message' => '\Drupal\contact\MessageViewBuilder',
      'file' => '\Drupal\Core\Entity\EntityViewBuilder',
      'menu_link_content' => '\Drupal\Core\Entity\EntityViewBuilder',
      'node' => '\Drupal\node\NodeViewBuilder',
      'path_alias' => '\Drupal\Core\Entity\EntityViewBuilder',
      'shortcut' => '\Drupal\Core\Entity\EntityViewBuilder',
      'taxonomy_term' => '\Drupal\Core\Entity\EntityViewBuilder',
      'tour' => '\Drupal\tour\TourViewBuilder',
      'user' => '\Drupal\Core\Entity\EntityViewBuilder',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
    map([
      'block' => '\Drupal\block\BlockListBuilder',
      'block_content_type' => '\Drupal\block_content\BlockContentTypeListBuilder',
      'block_content' => '\Drupal\block_content\BlockContentListBuilder',
      'comment' => '\Drupal\Core\Entity\EntityListBuilder',
      'comment_type' => '\Drupal\comment\CommentTypeListBuilder',
      'contact_form' => '\Drupal\contact\ContactFormListBuilder',
      'field_storage_config' => '\Drupal\field_ui\FieldStorageConfigListBuilder',
      'field_config' => '\Drupal\field_ui\FieldConfigListBuilder',
      'filter_format' => '\Drupal\filter\FilterFormatListBuilder',
      'image_style' => '\Drupal\image\ImageStyleListBuilder',
      'node_type' => '\Drupal\node\NodeTypeListBuilder',
      'node' => '\Drupal\node\NodeListBuilder',
      'path_alias' => '\Drupal\path\PathAliasListBuilder',
      'search_page' => '\Drupal\search\SearchPageListBuilder',
      'shortcut_set' => '\Drupal\shortcut\ShortcutSetListBuilder',
      'menu' => '\Drupal\menu_ui\MenuListBuilder',
      'taxonomy_vocabulary' => '\Drupal\taxonomy\VocabularyListBuilder',
      'taxonomy_term' => '\Drupal\Core\Entity\EntityListBuilder',
      'user_role' => '\Drupal\user\RoleListBuilder',
      'user' => '\Drupal\user\UserListBuilder',
      'view' => '\Drupal\views_ui\ViewListBuilder',
      'date_format' => '\Drupal\system\DateFormatListBuilder',
      'entity_form_mode' => '\Drupal\field_ui\EntityFormModeListBuilder',
      'entity_view_mode' => '\Drupal\field_ui\EntityDisplayModeListBuilder',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
    map([
     'block' => '\Drupal\block\BlockAccessControlHandler',
     'block_content_type' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'block_content' => '\Drupal\block_content\BlockContentAccessControlHandler',
     'comment' => '\Drupal\comment\CommentAccessControlHandler',
     'comment_type' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'contact_form' => '\Drupal\contact\ContactFormAccessControlHandler',
     'contact_message' => '\Drupal\contact\ContactMessageAccessControlHandler',
     'editor' => '\Drupal\editor\EditorAccessControlHandler',
     'field_storage_config' => '\Drupal\field\FieldStorageConfigAccessControlHandler',
     'field_config' => '\Drupal\field\FieldConfigAccessControlHandler',
     'file' => '\Drupal\file\FileAccessControlHandler',
     'filter_format' => '\Drupal\filter\FilterFormatAccessControlHandler',
     'image_style' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'menu_link_content' => '\Drupal\menu_link_content\MenuLinkContentAccessControlHandler',
     'node_type' => '\Drupal\node\NodeTypeAccessControlHandler',
     'node' => '\Drupal\node\NodeAccessControlHandler',
     'path_alias' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'rdf_mapping' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'search_page' => '\Drupal\search\SearchPageAccessControlHandler',
     'shortcut' => '\Drupal\shortcut\ShortcutAccessControlHandler',
     'shortcut_set' => '\Drupal\shortcut\ShortcutSetAccessControlHandler',
     'menu' => '\Drupal\system\MenuAccessControlHandler',
     'action' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'taxonomy_vocabulary' => '\Drupal\taxonomy\VocabularyAccessControlHandler',
     'taxonomy_term' => '\Drupal\taxonomy\TermAccessControlHandler',
     'tour' => '\Drupal\tour\TourAccessControlHandler',
     'user_role' => '\Drupal\user\RoleAccessControlHandler',
     'user' => '\Drupal\user\UserAccessControlHandler',
     'view' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'base_field_override' => '\Drupal\Core\Field\BaseFieldOverrideAccessControlHandler',
     'date_format' => '\Drupal\system\DateFormatAccessControlHandler',
     'entity_form_display' => '\Drupal\Core\Entity\Entity\Access\EntityFormDisplayAccessControlHandler',
     'entity_view_display' => '\Drupal\Core\Entity\Entity\Access\EntityViewDisplayAccessControlHandler',
     'entity_form_mode' => '\Drupal\Core\Entity\EntityAccessControlHandler',
     'entity_view_mode' => '\Drupal\Core\Entity\EntityAccessControlHandler',
    ])
  );

  override(\Drupal\block\Entity\Block::loadMultiple(), map(['' => '\Drupal\block\Entity\Block[]']));
  override(\Drupal\block\Entity\Block::load(), map(['' => '\Drupal\block\Entity\Block']));
  override(\Drupal\block\Entity\Block::create(), map(['' => '\Drupal\block\Entity\Block']));

  override(\Drupal\block_content\Entity\BlockContentType::loadMultiple(), map(['' => '\Drupal\block_content\Entity\BlockContentType[]']));
  override(\Drupal\block_content\Entity\BlockContentType::load(), map(['' => '\Drupal\block_content\Entity\BlockContentType']));
  override(\Drupal\block_content\Entity\BlockContentType::create(), map(['' => '\Drupal\block_content\Entity\BlockContentType']));

  override(\Drupal\block_content\Entity\BlockContent::loadMultiple(), map(['' => '\Drupal\block_content\Entity\BlockContent[]']));
  override(\Drupal\block_content\Entity\BlockContent::load(), map(['' => '\Drupal\block_content\Entity\BlockContent']));
  override(\Drupal\block_content\Entity\BlockContent::create(), map(['' => '\Drupal\block_content\Entity\BlockContent']));

  override(\Drupal\comment\Entity\Comment::loadMultiple(), map(['' => '\Drupal\comment\Entity\Comment[]']));
  override(\Drupal\comment\Entity\Comment::load(), map(['' => '\Drupal\comment\Entity\Comment']));
  override(\Drupal\comment\Entity\Comment::create(), map(['' => '\Drupal\comment\Entity\Comment']));

  override(\Drupal\comment\Entity\CommentType::loadMultiple(), map(['' => '\Drupal\comment\Entity\CommentType[]']));
  override(\Drupal\comment\Entity\CommentType::load(), map(['' => '\Drupal\comment\Entity\CommentType']));
  override(\Drupal\comment\Entity\CommentType::create(), map(['' => '\Drupal\comment\Entity\CommentType']));

  override(\Drupal\contact\Entity\ContactForm::loadMultiple(), map(['' => '\Drupal\contact\Entity\ContactForm[]']));
  override(\Drupal\contact\Entity\ContactForm::load(), map(['' => '\Drupal\contact\Entity\ContactForm']));
  override(\Drupal\contact\Entity\ContactForm::create(), map(['' => '\Drupal\contact\Entity\ContactForm']));

  override(\Drupal\contact\Entity\Message::loadMultiple(), map(['' => '\Drupal\contact\Entity\Message[]']));
  override(\Drupal\contact\Entity\Message::load(), map(['' => '\Drupal\contact\Entity\Message']));
  override(\Drupal\contact\Entity\Message::create(), map(['' => '\Drupal\contact\Entity\Message']));

  override(\Drupal\editor\Entity\Editor::loadMultiple(), map(['' => '\Drupal\editor\Entity\Editor[]']));
  override(\Drupal\editor\Entity\Editor::load(), map(['' => '\Drupal\editor\Entity\Editor']));
  override(\Drupal\editor\Entity\Editor::create(), map(['' => '\Drupal\editor\Entity\Editor']));

  override(\Drupal\field\Entity\FieldStorageConfig::loadMultiple(), map(['' => '\Drupal\field\Entity\FieldStorageConfig[]']));
  override(\Drupal\field\Entity\FieldStorageConfig::load(), map(['' => '\Drupal\field\Entity\FieldStorageConfig']));
  override(\Drupal\field\Entity\FieldStorageConfig::create(), map(['' => '\Drupal\field\Entity\FieldStorageConfig']));

  override(\Drupal\field\Entity\FieldConfig::loadMultiple(), map(['' => '\Drupal\field\Entity\FieldConfig[]']));
  override(\Drupal\field\Entity\FieldConfig::load(), map(['' => '\Drupal\field\Entity\FieldConfig']));
  override(\Drupal\field\Entity\FieldConfig::create(), map(['' => '\Drupal\field\Entity\FieldConfig']));

  override(\Drupal\file\Entity\File::loadMultiple(), map(['' => '\Drupal\file\Entity\File[]']));
  override(\Drupal\file\Entity\File::load(), map(['' => '\Drupal\file\Entity\File']));
  override(\Drupal\file\Entity\File::create(), map(['' => '\Drupal\file\Entity\File']));

  override(\Drupal\filter\Entity\FilterFormat::loadMultiple(), map(['' => '\Drupal\filter\Entity\FilterFormat[]']));
  override(\Drupal\filter\Entity\FilterFormat::load(), map(['' => '\Drupal\filter\Entity\FilterFormat']));
  override(\Drupal\filter\Entity\FilterFormat::create(), map(['' => '\Drupal\filter\Entity\FilterFormat']));

  override(\Drupal\image\Entity\ImageStyle::loadMultiple(), map(['' => '\Drupal\image\Entity\ImageStyle[]']));
  override(\Drupal\image\Entity\ImageStyle::load(), map(['' => '\Drupal\image\Entity\ImageStyle']));
  override(\Drupal\image\Entity\ImageStyle::create(), map(['' => '\Drupal\image\Entity\ImageStyle']));

  override(\Drupal\menu_link_content\Entity\MenuLinkContent::loadMultiple(), map(['' => '\Drupal\menu_link_content\Entity\MenuLinkContent[]']));
  override(\Drupal\menu_link_content\Entity\MenuLinkContent::load(), map(['' => '\Drupal\menu_link_content\Entity\MenuLinkContent']));
  override(\Drupal\menu_link_content\Entity\MenuLinkContent::create(), map(['' => '\Drupal\menu_link_content\Entity\MenuLinkContent']));

  override(\Drupal\node\Entity\NodeType::loadMultiple(), map(['' => '\Drupal\node\Entity\NodeType[]']));
  override(\Drupal\node\Entity\NodeType::load(), map(['' => '\Drupal\node\Entity\NodeType']));
  override(\Drupal\node\Entity\NodeType::create(), map(['' => '\Drupal\node\Entity\NodeType']));

  override(\Drupal\node\Entity\Node::loadMultiple(), map(['' => '\Drupal\node\Entity\Node[]']));
  override(\Drupal\node\Entity\Node::load(), map(['' => '\Drupal\node\Entity\Node']));
  override(\Drupal\node\Entity\Node::create(), map(['' => '\Drupal\node\Entity\Node']));

  override(\Drupal\path_alias\Entity\PathAlias::loadMultiple(), map(['' => '\Drupal\path_alias\Entity\PathAlias[]']));
  override(\Drupal\path_alias\Entity\PathAlias::load(), map(['' => '\Drupal\path_alias\Entity\PathAlias']));
  override(\Drupal\path_alias\Entity\PathAlias::create(), map(['' => '\Drupal\path_alias\Entity\PathAlias']));

  override(\Drupal\rdf\Entity\RdfMapping::loadMultiple(), map(['' => '\Drupal\rdf\Entity\RdfMapping[]']));
  override(\Drupal\rdf\Entity\RdfMapping::load(), map(['' => '\Drupal\rdf\Entity\RdfMapping']));
  override(\Drupal\rdf\Entity\RdfMapping::create(), map(['' => '\Drupal\rdf\Entity\RdfMapping']));

  override(\Drupal\search\Entity\SearchPage::loadMultiple(), map(['' => '\Drupal\search\Entity\SearchPage[]']));
  override(\Drupal\search\Entity\SearchPage::load(), map(['' => '\Drupal\search\Entity\SearchPage']));
  override(\Drupal\search\Entity\SearchPage::create(), map(['' => '\Drupal\search\Entity\SearchPage']));

  override(\Drupal\shortcut\Entity\Shortcut::loadMultiple(), map(['' => '\Drupal\shortcut\Entity\Shortcut[]']));
  override(\Drupal\shortcut\Entity\Shortcut::load(), map(['' => '\Drupal\shortcut\Entity\Shortcut']));
  override(\Drupal\shortcut\Entity\Shortcut::create(), map(['' => '\Drupal\shortcut\Entity\Shortcut']));

  override(\Drupal\shortcut\Entity\ShortcutSet::loadMultiple(), map(['' => '\Drupal\shortcut\Entity\ShortcutSet[]']));
  override(\Drupal\shortcut\Entity\ShortcutSet::load(), map(['' => '\Drupal\shortcut\Entity\ShortcutSet']));
  override(\Drupal\shortcut\Entity\ShortcutSet::create(), map(['' => '\Drupal\shortcut\Entity\ShortcutSet']));

  override(\Drupal\system\Entity\Menu::loadMultiple(), map(['' => '\Drupal\system\Entity\Menu[]']));
  override(\Drupal\system\Entity\Menu::load(), map(['' => '\Drupal\system\Entity\Menu']));
  override(\Drupal\system\Entity\Menu::create(), map(['' => '\Drupal\system\Entity\Menu']));

  override(\Drupal\system\Entity\Action::loadMultiple(), map(['' => '\Drupal\system\Entity\Action[]']));
  override(\Drupal\system\Entity\Action::load(), map(['' => '\Drupal\system\Entity\Action']));
  override(\Drupal\system\Entity\Action::create(), map(['' => '\Drupal\system\Entity\Action']));

  override(\Drupal\taxonomy\Entity\Vocabulary::loadMultiple(), map(['' => '\Drupal\taxonomy\Entity\Vocabulary[]']));
  override(\Drupal\taxonomy\Entity\Vocabulary::load(), map(['' => '\Drupal\taxonomy\Entity\Vocabulary']));
  override(\Drupal\taxonomy\Entity\Vocabulary::create(), map(['' => '\Drupal\taxonomy\Entity\Vocabulary']));

  override(\Drupal\taxonomy\Entity\Term::loadMultiple(), map(['' => '\Drupal\taxonomy\Entity\Term[]']));
  override(\Drupal\taxonomy\Entity\Term::load(), map(['' => '\Drupal\taxonomy\Entity\Term']));
  override(\Drupal\taxonomy\Entity\Term::create(), map(['' => '\Drupal\taxonomy\Entity\Term']));

  override(\Drupal\tour\Entity\Tour::loadMultiple(), map(['' => '\Drupal\tour\Entity\Tour[]']));
  override(\Drupal\tour\Entity\Tour::load(), map(['' => '\Drupal\tour\Entity\Tour']));
  override(\Drupal\tour\Entity\Tour::create(), map(['' => '\Drupal\tour\Entity\Tour']));

  override(\Drupal\user\Entity\Role::loadMultiple(), map(['' => '\Drupal\user\Entity\Role[]']));
  override(\Drupal\user\Entity\Role::load(), map(['' => '\Drupal\user\Entity\Role']));
  override(\Drupal\user\Entity\Role::create(), map(['' => '\Drupal\user\Entity\Role']));

  override(\Drupal\user\Entity\User::loadMultiple(), map(['' => '\Drupal\user\Entity\User[]']));
  override(\Drupal\user\Entity\User::load(), map(['' => '\Drupal\user\Entity\User']));
  override(\Drupal\user\Entity\User::create(), map(['' => '\Drupal\user\Entity\User']));

  override(\Drupal\views\Entity\View::loadMultiple(), map(['' => '\Drupal\views\Entity\View[]']));
  override(\Drupal\views\Entity\View::load(), map(['' => '\Drupal\views\Entity\View']));
  override(\Drupal\views\Entity\View::create(), map(['' => '\Drupal\views\Entity\View']));

  override(\Drupal\Core\Field\Entity\BaseFieldOverride::loadMultiple(), map(['' => '\Drupal\Core\Field\Entity\BaseFieldOverride[]']));
  override(\Drupal\Core\Field\Entity\BaseFieldOverride::load(), map(['' => '\Drupal\Core\Field\Entity\BaseFieldOverride']));
  override(\Drupal\Core\Field\Entity\BaseFieldOverride::create(), map(['' => '\Drupal\Core\Field\Entity\BaseFieldOverride']));

  override(\Drupal\Core\Datetime\Entity\DateFormat::loadMultiple(), map(['' => '\Drupal\Core\Datetime\Entity\DateFormat[]']));
  override(\Drupal\Core\Datetime\Entity\DateFormat::load(), map(['' => '\Drupal\Core\Datetime\Entity\DateFormat']));
  override(\Drupal\Core\Datetime\Entity\DateFormat::create(), map(['' => '\Drupal\Core\Datetime\Entity\DateFormat']));

  override(\Drupal\Core\Entity\Entity\EntityFormDisplay::loadMultiple(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormDisplay[]']));
  override(\Drupal\Core\Entity\Entity\EntityFormDisplay::load(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormDisplay']));
  override(\Drupal\Core\Entity\Entity\EntityFormDisplay::create(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormDisplay']));

  override(\Drupal\Core\Entity\Entity\EntityViewDisplay::loadMultiple(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewDisplay[]']));
  override(\Drupal\Core\Entity\Entity\EntityViewDisplay::load(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewDisplay']));
  override(\Drupal\Core\Entity\Entity\EntityViewDisplay::create(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewDisplay']));

  override(\Drupal\Core\Entity\Entity\EntityFormMode::loadMultiple(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormMode[]']));
  override(\Drupal\Core\Entity\Entity\EntityFormMode::load(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormMode']));
  override(\Drupal\Core\Entity\Entity\EntityFormMode::create(), map(['' => '\Drupal\Core\Entity\Entity\EntityFormMode']));

  override(\Drupal\Core\Entity\Entity\EntityViewMode::loadMultiple(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewMode[]']));
  override(\Drupal\Core\Entity\Entity\EntityViewMode::load(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewMode']));
  override(\Drupal\Core\Entity\Entity\EntityViewMode::create(), map(['' => '\Drupal\Core\Entity\Entity\EntityViewMode']));

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

}
