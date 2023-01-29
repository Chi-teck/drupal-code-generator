<?php declare(strict_types = 1);

/**
 * @file
 * Service metadata.
 *
 * @todo Remove tagged services as they are not typically injected explicitly.
 */

use Drupal\Core\Access\AccessArgumentsResolverFactoryInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Theme\ThemeAccessCheck;
use Drupal\Core\Access\AccessManagerInterface;
use Drupal\Core\Session\AccountSwitcherInterface;
use Drupal\Core\Render\AttachmentsResponseProcessorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Asset\AssetCollectionGrouperInterface;
use Drupal\Core\Asset\AssetCollectionOptimizerInterface;
use Drupal\Core\Asset\AssetCollectionRendererInterface;
use Drupal\Core\Asset\AssetDumperInterface;
use Drupal\Core\Asset\AssetOptimizerInterface;
use Drupal\Core\Asset\AssetResolverInterface;
use Drupal\Core\Authentication\AuthenticationProviderInterface;
use Drupal\Core\Authentication\AuthenticationCollectorInterface;
use Drupal\Core\Render\BareHtmlPageRendererInterface;
use Drupal\Core\Batch\BatchStorageInterface;
use Drupal\big_pipe\Render\BigPipe;
use Drupal\block\BlockRepositoryInterface;
use Drupal\Core\DestructableInterface;
use Drupal\Core\Breadcrumb\ChainBreadcrumbBuilderInterface;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Cache\CacheFactoryInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Cache\Context\CalculatedCacheContextInterface;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Cache\Context\RequestFormatCacheContext;
use Drupal\Core\Cache\Context\SessionCacheContext;
use Drupal\Core\Cache\Context\CacheContextsManager;
use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\Cache\CacheTagsChecksumInterface;
use Drupal\Core\DependencyInjection\ClassResolverInterface;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\comment\CommentLinkBuilderInterface;
use Drupal\comment\CommentManagerInterface;
use Drupal\comment\CommentStatisticsInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImportStorageTransformer;
use Drupal\Core\Config\ConfigInstallerInterface;
use Drupal\Core\Config\ConfigManagerInterface;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\contact\MailHandlerInterface;
use Drupal\Core\Routing\FilterInterface;
use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\Plugin\Context\ContextHandlerInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Drupal\Core\Entity\HtmlEntityFormController;
use Drupal\Core\Controller\HtmlFormController;
use Drupal\Core\Controller\ControllerResolverInterface;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Access\CsrfTokenGenerator;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Database\ReplicaKillSwitch;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Diff\DiffFormatter;
use Drupal\Core\PageCache\ChainResponsePolicyInterface;
use Drupal\Core\Extension\ConfigImportModuleUninstallValidatorInterface;
use Symfony\Component\Mime\MimeTypeGuesserInterface;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\Core\Plugin\CachedDiscoveryClearerInterface;
use Drupal\Core\Routing\RouteBuilderInterface;
use Drupal\Core\Routing\MatcherDumperInterface;
use Drupal\Core\PageCache\RequestPolicyInterface;
use Drupal\Core\PageCache\ResponsePolicyInterface;
use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Entity\EntityAutocompleteMatcherInterface;
use Drupal\Core\Entity\EntityDefinitionUpdateManagerInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityLastInstalledSchemaRepositoryInterface;
use Drupal\Core\Entity\Query\QueryFactoryInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityBundleListenerInterface;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Field\DeletedFieldsRepositoryInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeListenerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityTypeRepositoryInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Extension\ProfileExtensionList;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Extension\ThemeEngineExtensionList;
use Drupal\Core\Extension\ExtensionPathResolver;
use Drupal\Core\Field\FieldDefinitionListenerInterface;
use Drupal\Core\Field\FieldStorageDefinitionListenerInterface;
use Drupal\Core\File\HtaccessWriterInterface;
use Drupal\file\FileRepositoryInterface;
use Drupal\file\Upload\FileUploadHandler;
use Drupal\file\FileUsage\FileUsageInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Form\FormAjaxResponseBuilderInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormErrorHandlerInterface;
use Drupal\Core\Form\FormSubmitterInterface;
use Drupal\Core\Form\FormValidatorInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Http\ClientFactory;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Drupal\Core\Image\ImageFactory;
use Drupal\Core\ImageToolkit\ImageToolkitManager;
use Drupal\Core\Extension\InfoParserInterface;
use Drupal\Core\DrupalKernelInterface;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueExpirableFactoryInterface;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Drupal\Core\Language\LanguageDefault;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Asset\LibraryDependencyResolverInterface;
use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\Core\Cache\CacheCollectorInterface;
use Drupal\Core\Asset\LibraryDiscoveryParser;
use Drupal\Core\Asset\LibrariesDirectoryFileFinder;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Psr\Log\LoggerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LogMessageParserInterface;
use Drupal\Core\Render\MainContent\MainContentRendererInterface;
use Drupal\Core\Site\MaintenanceModeInterface;
use Drupal\Core\Menu\MenuActiveTrailInterface;
use Drupal\Core\Menu\DefaultMenuLinkTreeManipulators;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Menu\MenuParentFormSelectorInterface;
use Drupal\Core\Menu\StaticMenuLinkOverridesInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\node\NodeGrantDatabaseStorageInterface;
use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Pager\PagerParametersInterface;
use Drupal\Core\ParamConverter\ParamConverterManagerInterface;
use Drupal\Core\Password\PasswordInterface;
use Drupal\Core\Password\PasswordGeneratorInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathMatcherInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\path_alias\AliasManagerInterface;
use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Drupal\path_alias\AliasRepositoryInterface;
use Drupal\Core\Render\Placeholder\PlaceholderStrategyInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Render\ElementInfoManagerInterface;
use Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\Queue\QueueWorkerManagerInterface;
use Drupal\Core\Plugin\PluginFormFactoryInterface;
use Drupal\Core\PrivateKey;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueDatabaseFactory;
use Drupal\Core\Routing\RedirectDestinationInterface;
use Drupal\Core\Render\RenderCacheInterface;
use Drupal\Core\Render\PlaceholderGeneratorInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Entity\EntityResolverManager;
use Drupal\Core\Routing\EnhancerInterface;
use Drupal\Core\RouteProcessor\OutboundRouteProcessorInterface;
use Drupal\Core\Routing\AccessAwareRouterInterface;
use Drupal\Core\Routing\AdminContext;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Drupal\Core\Routing\RequestContext;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\Core\Routing\PreloadableRouteProviderInterface;
use Drupal\search\SearchIndexInterface;
use Drupal\search\SearchPageRepositoryInterface;
use Drupal\search\SearchTextProcessorInterface;
use Drupal\Component\Serialization\SerializationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Drupal\Core\Session\SessionConfigurationInterface;
use Drupal\Core\Session\WriteSafeSessionHandlerInterface;
use Drupal\Core\Session\MetadataBag;
use Drupal\Core\Site\Settings;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StreamWrapper\PhpStreamWrapperInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\StringTranslation\Translator\TranslatorInterface;
use Drupal\system\SystemManager;
use Drupal\system\SecurityAdvisories\SecurityAdvisoriesFetcher;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\Core\TempStore\SharedTempStoreFactory;
use Drupal\Core\Theme\ThemeInitializationInterface;
use Drupal\Core\Theme\ThemeManagerInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\Core\Theme\Registry;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Extension\ThemeInstallerInterface;
use Drupal\Core\Controller\TitleResolverInterface;
use Drupal\Core\Utility\Token;
use Drupal\Component\Transliteration\TransliterationInterface;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\LoaderInterface;
use Drupal\Core\TypedData\TypedDataManagerInterface;
use Drupal\Core\Utility\UnroutedUrlAssemblerInterface;
use Drupal\update\UpdateFetcherInterface;
use Drupal\update\UpdateManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Drupal\update\UpdateProcessorInterface;
use Drupal\Core\Update\UpdateHookRegistry;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\user\UserAuthInterface;
use Drupal\user\UserDataInterface;
use Drupal\user\UserFloodControlInterface;
use Drupal\user\PermissionHandlerInterface;
use Drupal\Core\Session\PermissionsHashGeneratorInterface;
use Drupal\Component\Uuid\UuidInterface;
use Drupal\views\Analyzer;
use Drupal\views\Plugin\views\query\DateSqlInterface;
use Drupal\views\ViewExecutableFactory;
use Drupal\views\ExposedFormCache;
use Drupal\views\ViewsData;
use Drupal\views\ViewsDataHelper;

return [
  'access_arguments_resolver_factory' => [
    'type' => AccessArgumentsResolverFactoryInterface::class,
    'name' => 'argumentsResolverFactory',
  ],
  'access_check.contact_personal' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckContactPersonal',
  ],
  'access_check.cron' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckCron',
  ],
  'access_check.csrf' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckCsrf',
  ],
  'access_check.custom' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckCustom',
  ],
  'access_check.db_update' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckDbUpdate',
  ],
  'access_check.default' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckDefault',
  ],
  'access_check.entity' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckEntity',
  ],
  'access_check.entity_create' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckEntityCreate',
  ],
  'access_check.entity_create_any' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckEntityCreateAny',
  ],
  'access_check.entity_delete_multiple' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckEntityDeleteMultiple',
  ],
  'access_check.field_ui.form_mode' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckFieldUiFormMode',
  ],
  'access_check.field_ui.view_mode' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckFieldUiViewMode',
  ],
  'access_check.header.csrf' => [
    'type' => AccessCheckInterface::class,
    'name' => 'accessCheckHeaderCsrf',
  ],
  'access_check.node.preview' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckNodePreview',
  ],
  'access_check.permission' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckPermission',
  ],
  'access_check.theme' => [
    'type' => ThemeAccessCheck::class,
    'name' => 'themeAccess',
  ],
  'access_check.update.manager_access' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckUpdateManagerAccess',
  ],
  'access_check.user.login_status' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckUserLoginStatus',
  ],
  'access_check.user.register' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckUserRegister',
  ],
  'access_check.user.role' => [
    'type' => AccessInterface::class,
    'name' => 'accessCheckUserRole',
  ],
  'access_manager' => [
    'type' => AccessManagerInterface::class,
    'name' => 'accessManager',
  ],
  'account_switcher' => [
    'type' => AccountSwitcherInterface::class,
    'name' => 'accountSwitcher',
  ],
  'ajax_response.attachments_processor' => [
    'type' => AttachmentsResponseProcessorInterface::class,
    'name' => 'ajaxResponseAttachmentsProcessor',
  ],
  'ajax_response.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'ajaxResponseSubscriber',
  ],
  'anonymous_user_response_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'anonymousUserResponseSubscriber',
  ],
  'asset.css.collection_grouper' => [
    'type' => AssetCollectionGrouperInterface::class,
    'name' => 'grouper',
  ],
  'asset.css.collection_optimizer' => [
    'type' => AssetCollectionOptimizerInterface::class,
    'name' => 'cssCollectionOptimizer',
  ],
  'asset.css.collection_renderer' => [
    'type' => AssetCollectionRendererInterface::class,
    'name' => 'cssCollectionRenderer',
  ],
  'asset.css.dumper' => [
    'type' => AssetDumperInterface::class,
    'name' => 'dumper',
  ],
  'asset.css.optimizer' => [
    'type' => AssetOptimizerInterface::class,
    'name' => 'optimizer',
  ],
  'asset.js.collection_grouper' => [
    'type' => AssetCollectionGrouperInterface::class,
    'name' => 'grouper',
  ],
  'asset.js.collection_optimizer' => [
    'type' => AssetCollectionOptimizerInterface::class,
    'name' => 'assetJsCollectionOptimizer',
  ],
  'asset.js.collection_renderer' => [
    'type' => AssetCollectionRendererInterface::class,
    'name' => 'jsCollectionRenderer',
  ],
  'asset.js.dumper' => [
    'type' => AssetDumperInterface::class,
    'name' => 'dumper',
  ],
  'asset.js.optimizer' => [
    'type' => AssetOptimizerInterface::class,
    'name' => 'optimizer',
  ],
  'asset.resolver' => [
    'type' => AssetResolverInterface::class,
    'name' => 'assetResolver',
  ],
  'authentication' => [
    'type' => AuthenticationProviderInterface::class,
    'name' => 'authenticationProvider',
  ],
  'authentication_collector' => [
    'type' => AuthenticationCollectorInterface::class,
    'name' => 'authCollector',
  ],
  'authentication_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'authenticationSubscriber',
  ],
  'automated_cron.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'automatedCronSubscriber',
  ],
  'bare_html_page_renderer' => [
    'type' => BareHtmlPageRendererInterface::class,
    'name' => 'bareHtmlPageRenderer',
  ],
  'batch.storage' => [
    'type' => BatchStorageInterface::class,
    'name' => 'batchStorage',
  ],
  'big_pipe' => [
    'type' => BigPipe::class,
    'name' => 'bigPipe',
  ],
  'block.page_display_variant_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'blockPageDisplayVariantSubscriber',
  ],
  'block.repository' => [
    'type' => BlockRepositoryInterface::class,
    'name' => 'blockRepository',
  ],
  'block_content.uuid_lookup' => [
    'type' => DestructableInterface::class,
    'name' => 'blockContentUuidLookup',
  ],
  'breadcrumb' => [
    'type' => ChainBreadcrumbBuilderInterface::class,
    'name' => 'breadcrumb',
  ],
  'breakpoint.manager' => [
    'type' => PluginManagerInterface::class,
    'name' => 'breakpointManager',
  ],
  'cache.backend.apcu' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheBackendApcu',
  ],
  'cache.backend.chainedfast' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheBackendChainedfast',
  ],
  'cache.backend.database' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheBackendDatabase',
  ],
  'cache.backend.memory' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheBackendMemory',
  ],
  'cache.backend.php' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheBackendPhp',
  ],
  'cache.bootstrap' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cache',
  ],
  'cache.config' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cache',
  ],
  'cache.data' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheBackend',
  ],
  'cache.default' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cache',
  ],
  'cache.discovery' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheBackend',
  ],
  'cache.dynamic_page_cache' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheDynamicPageCache',
  ],
  'cache.entity' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheEntity',
  ],
  'cache.menu' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cache',
  ],
  'cache.page' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cache',
  ],
  'cache.render' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheRender',
  ],
  'cache.static' => [
    'type' => CacheBackendInterface::class,
    'name' => 'static',
  ],
  'cache.toolbar' => [
    'type' => CacheBackendInterface::class,
    'name' => 'cacheToolbar',
  ],
  'cache_context.cookies' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextCookies',
  ],
  'cache_context.headers' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextHeaders',
  ],
  'cache_context.ip' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextIp',
  ],
  'cache_context.languages' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextLanguages',
  ],
  'cache_context.protocol_version' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextProtocolVersion',
  ],
  'cache_context.request_format' => [
    'type' => RequestFormatCacheContext::class,
    'name' => 'cacheContextRequestFormat',
  ],
  'cache_context.route' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextRoute',
  ],
  'cache_context.route.menu_active_trails' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextRouteMenuActiveTrails',
  ],
  'cache_context.route.name' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextRouteName',
  ],
  'cache_context.session' => [
    'type' => SessionCacheContext::class,
    'name' => 'cacheContextSession',
  ],
  'cache_context.session.exists' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextSessionExists',
  ],
  'cache_context.theme' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextTheme',
  ],
  'cache_context.timezone' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextTimezone',
  ],
  'cache_context.url' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUrl',
  ],
  'cache_context.url.path' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUrlPath',
  ],
  'cache_context.url.path.is_front' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUrlPathIsFront',
  ],
  'cache_context.url.path.parent' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUrlPathParent',
  ],
  'cache_context.url.query_args' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextUrlQueryArgs',
  ],
  'cache_context.url.query_args.pagers' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextUrlQueryArgsPagers',
  ],
  'cache_context.url.site' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUrlSite',
  ],
  'cache_context.user' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUser',
  ],
  'cache_context.user.is_super_user' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUserIsSuperUser',
  ],
  'cache_context.user.node_grants' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextUserNodeGrants',
  ],
  'cache_context.user.permissions' => [
    'type' => CacheContextInterface::class,
    'name' => 'cacheContextUserPermissions',
  ],
  'cache_context.user.roles' => [
    'type' => CalculatedCacheContextInterface::class,
    'name' => 'cacheContextUserRoles',
  ],
  'cache_contexts_manager' => [
    'type' => CacheContextsManager::class,
    'name' => 'cacheContextsManager',
  ],
  'cache_factory' => [
    'type' => CacheFactoryInterface::class,
    'name' => 'cacheFactory',
  ],
  'cache_router_rebuild_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'cacheRouterRebuildSubscriber',
  ],
  'cache_tags.invalidator' => [
    'type' => CacheTagsInvalidatorInterface::class,
    'name' => 'cacheTagsInvalidator',
  ],
  'cache_tags.invalidator.checksum' => [
    'type' => CacheTagsChecksumInterface::class,
    'name' => 'checksumProvider',
  ],
  'class_resolver' => [
    'type' => ClassResolverInterface::class,
    'name' => 'classResolver',
  ],
  'client_error_response_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'clientErrorResponseSubscriber',
  ],
  'comment.breadcrumb' => [
    'type' => BreadcrumbBuilderInterface::class,
    'name' => 'commentBreadcrumb',
  ],
  'comment.lazy_builders' => [
    'type' => TrustedCallbackInterface::class,
    'name' => 'commentLazyBuilders',
  ],
  'comment.link_builder' => [
    'type' => CommentLinkBuilderInterface::class,
    'name' => 'commentLinkBuilder',
  ],
  'comment.manager' => [
    'type' => CommentManagerInterface::class,
    'name' => 'commentManager',
  ],
  'comment.statistics' => [
    'type' => CommentStatisticsInterface::class,
    'name' => 'commentStatistics',
  ],
  'config.config_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'configConfigSubscriber',
  ],
  'config.factory' => [
    'type' => ConfigFactoryInterface::class,
    'name' => 'configFactory',
  ],
  'config.import_transformer' => [
    'type' => ImportStorageTransformer::class,
    'name' => 'configImportTransformer',
  ],
  'config.importer_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'configImporterSubscriber',
  ],
  'config.installer' => [
    'type' => ConfigInstallerInterface::class,
    'name' => 'configInstaller',
  ],
  'config.manager' => [
    'type' => ConfigManagerInterface::class,
    'name' => 'configManager',
  ],
  'config.storage' => [
    'type' => StorageInterface::class,
    'name' => 'activeStorage',
  ],
  'config.storage.export' => [
    'type' => StorageInterface::class,
    'name' => 'configStorageExport',
  ],
  'config.storage.schema' => [
    'type' => StorageInterface::class,
    'name' => 'schemaStorage',
  ],
  'config.storage.snapshot' => [
    'type' => StorageInterface::class,
    'name' => 'configStorageSnapshot',
  ],
  'config.storage.sync' => [
    'type' => StorageInterface::class,
    'name' => 'configStorageSync',
  ],
  'config.typed' => [
    'type' => TypedConfigManagerInterface::class,
    'name' => 'typedConfig',
  ],
  'config_exclude_modules_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'configExcludeModulesSubscriber',
  ],
  'config_import_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'configImportSubscriber',
  ],
  'contact.mail_handler' => [
    'type' => MailHandlerInterface::class,
    'name' => 'contactMailHandler',
  ],
  'container.namespaces' => [
    'type' => \Traversable::class,
    'name' => 'namespaces',
  ],
  'content_type_header_matcher' => [
    'type' => FilterInterface::class,
    'name' => 'contentTypeHeaderMatcher',
  ],
  'content_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'contentUninstallValidator',
  ],
  'context.handler' => [
    'type' => ContextHandlerInterface::class,
    'name' => 'contextHandler',
  ],
  'context.repository' => [
    'type' => ContextRepositoryInterface::class,
    'name' => 'contextRepository',
  ],
  'controller.entity_form' => [
    'type' => HtmlEntityFormController::class,
    'name' => 'controllerEntityForm',
  ],
  'controller.form' => [
    'type' => HtmlFormController::class,
    'name' => 'controllerForm',
  ],
  'controller_resolver' => [
    'type' => ControllerResolverInterface::class,
    'name' => 'controllerResolver',
  ],
  'country_manager' => [
    'type' => CountryManagerInterface::class,
    'name' => 'countryManager',
  ],
  'cron' => [
    'type' => CronInterface::class,
    'name' => 'cron',
  ],
  'csrf_token' => [
    'type' => CsrfTokenGenerator::class,
    'name' => 'csrfToken',
  ],
  'current_route_match' => [
    'type' => RouteMatchInterface::class,
    'name' => 'routeMatch',
  ],
  'current_user' => [
    'type' => AccountInterface::class,
    'name' => 'account',
  ],
  'database' => [
    'type' => Connection::class,
    'name' => 'connection',
  ],
  'database.replica' => [
    'type' => Connection::class,
    'name' => 'databaseReplica',
  ],
  'database.replica_kill_switch' => [
    'type' => ReplicaKillSwitch::class,
    'name' => 'replicaKillSwitch',
  ],
  'database_driver_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'databaseDriverUninstallValidator',
  ],
  'date.formatter' => [
    'type' => DateFormatterInterface::class,
    'name' => 'dateFormatter',
  ],
  'datetime.time' => [
    'type' => TimeInterface::class,
    'name' => 'time',
  ],
  'diff.formatter' => [
    'type' => DiffFormatter::class,
    'name' => 'diffFormatter',
  ],
  'drupal.proxy_original_service.bare_html_page_renderer' => [
    'type' => BareHtmlPageRendererInterface::class,
    'name' => 'drupalProxyOriginalServiceBareHtmlPageRenderer',
  ],
  'drupal.proxy_original_service.batch.storage' => [
    'type' => BatchStorageInterface::class,
    'name' => 'drupalProxyOriginalServiceBatchStorage',
  ],
  'drupal.proxy_original_service.config.installer' => [
    'type' => ConfigInstallerInterface::class,
    'name' => 'drupalProxyOriginalServiceConfigInstaller',
  ],
  'drupal.proxy_original_service.content_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceContentUninstallValidator',
  ],
  'drupal.proxy_original_service.cron' => [
    'type' => CronInterface::class,
    'name' => 'drupalProxyOriginalServiceCron',
  ],
  'drupal.proxy_original_service.database_driver_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceDatabaseDriverUninstallValidator',
  ],
  'drupal.proxy_original_service.dynamic_page_cache_response_policy' => [
    'type' => ChainResponsePolicyInterface::class,
    'name' => 'drupalProxyOriginalServiceDynamicPageCacheResponsePolicy',
  ],
  'drupal.proxy_original_service.field.uninstall_validator' => [
    'type' => ConfigImportModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceFieldUninstallValidator',
  ],
  'drupal.proxy_original_service.file.mime_type.guesser' => [
    'type' => MimeTypeGuesserInterface::class,
    'name' => 'drupalProxyOriginalServiceFileMimeTypeGuesser',
  ],
  'drupal.proxy_original_service.file.mime_type.guesser.extension' => [
    'type' => MimeTypeGuesserInterface::class,
    'name' => 'drupalProxyOriginalServiceFileMimeTypeGuesserExtension',
  ],
  'drupal.proxy_original_service.filter.uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceFilterUninstallValidator',
  ],
  'drupal.proxy_original_service.lock' => [
    'type' => LockBackendInterface::class,
    'name' => 'drupalProxyOriginalServiceLock',
  ],
  'drupal.proxy_original_service.lock.persistent' => [
    'type' => LockBackendInterface::class,
    'name' => 'drupalProxyOriginalServiceLockPersistent',
  ],
  'drupal.proxy_original_service.module_required_by_themes_uninstall_validator' => [
    'type' => ConfigImportModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceModuleRequiredByThemesUninstallValidator',
  ],
  'drupal.proxy_original_service.node_preview' => [
    'type' => ParamConverterInterface::class,
    'name' => 'drupalProxyOriginalServiceNodePreview',
  ],
  'drupal.proxy_original_service.page_cache_response_policy' => [
    'type' => ChainResponsePolicyInterface::class,
    'name' => 'drupalProxyOriginalServicePageCacheResponsePolicy',
  ],
  'drupal.proxy_original_service.paramconverter.menu_link' => [
    'type' => ParamConverterInterface::class,
    'name' => 'drupalProxyOriginalServiceParamconverterMenuLink',
  ],
  'drupal.proxy_original_service.paramconverter.views_ui' => [
    'type' => ParamConverterInterface::class,
    'name' => 'drupalProxyOriginalServiceParamconverterViewsUi',
  ],
  'drupal.proxy_original_service.plugin.cache_clearer' => [
    'type' => CachedDiscoveryClearerInterface::class,
    'name' => 'drupalProxyOriginalServicePluginCacheClearer',
  ],
  'drupal.proxy_original_service.required_module_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'drupalProxyOriginalServiceRequiredModuleUninstallValidator',
  ],
  'drupal.proxy_original_service.router.builder' => [
    'type' => RouteBuilderInterface::class,
    'name' => 'drupalProxyOriginalServiceRouterBuilder',
  ],
  'drupal.proxy_original_service.router.dumper' => [
    'type' => MatcherDumperInterface::class,
    'name' => 'drupalProxyOriginalServiceRouterDumper',
  ],
  'dynamic_page_cache_request_policy' => [
    'type' => RequestPolicyInterface::class,
    'name' => 'requestPolicy',
  ],
  'dynamic_page_cache_response_policy' => [
    'type' => ResponsePolicyInterface::class,
    'name' => 'responsePolicy',
  ],
  'dynamic_page_cache_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'dynamicPageCacheSubscriber',
  ],
  'early_rendering_controller_wrapper_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'earlyRenderingControllerWrapperSubscriber',
  ],
  'editor.config_translation_mapper_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'editorConfigTranslationMapperSubscriber',
  ],
  'element.editor' => [
    'type' => TrustedCallbackInterface::class,
    'name' => 'elementEditor',
  ],
  'email.validator' => [
    'type' => EmailValidatorInterface::class,
    'name' => 'emailValidator',
  ],
  'entity.autocomplete_matcher' => [
    'type' => EntityAutocompleteMatcherInterface::class,
    'name' => 'entityAutocompleteMatcher',
  ],
  'entity.bundle_config_import_validator' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'entityBundleConfigImportValidator',
  ],
  'entity.definition_update_manager' => [
    'type' => EntityDefinitionUpdateManagerInterface::class,
    'name' => 'entityDefinitionUpdateManager',
  ],
  'entity.form_builder' => [
    'type' => EntityFormBuilderInterface::class,
    'name' => 'entityFormBuilder',
  ],
  'entity.last_installed_schema.repository' => [
    'type' => EntityLastInstalledSchemaRepositoryInterface::class,
    'name' => 'entityLastInstalledSchemaRepository',
  ],
  'entity.memory_cache' => [
    'type' => CacheBackendInterface::class,
    'name' => 'entityMemoryCache',
  ],
  'entity.query.config' => [
    'type' => QueryFactoryInterface::class,
    'name' => 'entityQueryConfig',
  ],
  'entity.query.keyvalue' => [
    'type' => QueryFactoryInterface::class,
    'name' => 'entityQueryKeyvalue',
  ],
  'entity.query.null' => [
    'type' => QueryFactoryInterface::class,
    'name' => 'entityQueryNull',
  ],
  'entity.query.sql' => [
    'type' => QueryFactoryInterface::class,
    'name' => 'entityQuerySql',
  ],
  'entity.repository' => [
    'type' => EntityRepositoryInterface::class,
    'name' => 'entityRepository',
  ],
  'entity_bundle.listener' => [
    'type' => EntityBundleListenerInterface::class,
    'name' => 'entityBundleListener',
  ],
  'entity_display.repository' => [
    'type' => EntityDisplayRepositoryInterface::class,
    'name' => 'entityDisplayRepository',
  ],
  'entity_field.deleted_fields_repository' => [
    'type' => DeletedFieldsRepositoryInterface::class,
    'name' => 'deletedFieldsRepository',
  ],
  'entity_field.manager' => [
    'type' => EntityFieldManagerInterface::class,
    'name' => 'entityFieldManager',
  ],
  'entity_route_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'entityRouteSubscriber',
  ],
  'entity_type.bundle.info' => [
    'type' => EntityTypeBundleInfoInterface::class,
    'name' => 'entityTypeBundleInfo',
  ],
  'entity_type.listener' => [
    'type' => EntityTypeListenerInterface::class,
    'name' => 'entityTypeListener',
  ],
  'entity_type.manager' => [
    'type' => EntityTypeManagerInterface::class,
    'name' => 'entityTypeManager',
  ],
  'entity_type.repository' => [
    'type' => EntityTypeRepositoryInterface::class,
    'name' => 'entityTypeRepository',
  ],
  'event_dispatcher' => [
    'type' => EventDispatcherInterface::class,
    'name' => 'eventDispatcher',
  ],
  'exception.custom_page_html' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionCustomPageHtml',
  ],
  'exception.default_html' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionDefaultHtml',
  ],
  'exception.default_json' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionDefaultJson',
  ],
  'exception.enforced_form_response' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionEnforcedFormResponse',
  ],
  'exception.fast_404_html' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionFast404Html',
  ],
  'exception.final' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionFinal',
  ],
  'exception.logger' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionLogger',
  ],
  'exception.needs_installer' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'exceptionNeedsInstaller',
  ],
  'extension.list.module' => [
    'type' => ModuleExtensionList::class,
    'name' => 'extensionListModule',
  ],
  'extension.list.profile' => [
    'type' => ProfileExtensionList::class,
    'name' => 'profileList',
  ],
  'extension.list.theme' => [
    'type' => ThemeExtensionList::class,
    'name' => 'themeList',
  ],
  'extension.list.theme_engine' => [
    'type' => ThemeEngineExtensionList::class,
    'name' => 'engineList',
  ],
  'extension.path.resolver' => [
    'type' => ExtensionPathResolver::class,
    'name' => 'extensionPathResolver',
  ],
  'field.uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'fieldUninstallValidator',
  ],
  'field_definition.listener' => [
    'type' => FieldDefinitionListenerInterface::class,
    'name' => 'fieldDefinitionListener',
  ],
  'field_storage_definition.listener' => [
    'type' => FieldStorageDefinitionListenerInterface::class,
    'name' => 'fieldStorageDefinitionListener',
  ],
  'field_ui.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'fieldUiSubscriber',
  ],
  'file.htaccess_writer' => [
    'type' => HtaccessWriterInterface::class,
    'name' => 'fileHtaccessWriter',
  ],
  'file.mime_type.guesser' => [
    'type' => MimeTypeGuesserInterface::class,
    'name' => 'mimeTypeGuesser',
  ],
  'file.mime_type.guesser.extension' => [
    'type' => MimeTypeGuesserInterface::class,
    'name' => 'fileMimeTypeGuesserExtension',
  ],
  'file.repository' => [
    'type' => FileRepositoryInterface::class,
    'name' => 'fileRepository',
  ],
  'file.upload_handler' => [
    'type' => FileUploadHandler::class,
    'name' => 'fileUploadHandler',
  ],
  'file.usage' => [
    'type' => FileUsageInterface::class,
    'name' => 'fileUsage',
  ],
  'file_system' => [
    'type' => FileSystemInterface::class,
    'name' => 'fileSystem',
  ],
  'file_url_generator' => [
    'type' => FileUrlGeneratorInterface::class,
    'name' => 'fileUrlGenerator',
  ],
  'filter.uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'filterUninstallValidator',
  ],
  'finish_response_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'finishResponseSubscriber',
  ],
  'flood' => [
    'type' => FloodInterface::class,
    'name' => 'flood',
  ],
  'form_ajax_response_builder' => [
    'type' => FormAjaxResponseBuilderInterface::class,
    'name' => 'formAjaxResponseBuilder',
  ],
  'form_ajax_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'formAjaxSubscriber',
  ],
  'form_builder' => [
    'type' => FormBuilderInterface::class,
    'name' => 'formBuilder',
  ],
  'form_error_handler' => [
    'type' => FormErrorHandlerInterface::class,
    'name' => 'formErrorHandler',
  ],
  'form_submitter' => [
    'type' => FormSubmitterInterface::class,
    'name' => 'formSubmitter',
  ],
  'form_validator' => [
    'type' => FormValidatorInterface::class,
    'name' => 'formValidator',
  ],
  'html_response.attachments_processor' => [
    'type' => AttachmentsResponseProcessorInterface::class,
    'name' => 'htmlResponseAttachmentsProcessor',
  ],
  'html_response.big_pipe_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'htmlResponseBigPipeSubscriber',
  ],
  'html_response.placeholder_strategy_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'htmlResponsePlaceholderStrategySubscriber',
  ],
  'html_response.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'htmlResponseSubscriber',
  ],
  'http_client' => [
    'type' => ClientInterface::class,
    'name' => 'client',
  ],
  'http_client_factory' => [
    'type' => ClientFactory::class,
    'name' => 'httpClientFactory',
  ],
  'http_kernel' => [
    'type' => HttpKernelInterface::class,
    'name' => 'httpKernel',
  ],
  'http_kernel.basic' => [
    'type' => HttpKernelInterface::class,
    'name' => 'httpKernel',
  ],
  'http_kernel.controller.argument_resolver' => [
    'type' => ArgumentResolverInterface::class,
    'name' => 'argumentResolver',
  ],
  'http_middleware.kernel_pre_handle' => [
    'type' => HttpKernelInterface::class,
    'name' => 'httpKernel',
  ],
  'http_middleware.negotiation' => [
    'type' => HttpKernelInterface::class,
    'name' => 'kernel',
  ],
  'http_middleware.page_cache' => [
    'type' => HttpKernelInterface::class,
    'name' => 'httpKernel',
  ],
  'http_middleware.reverse_proxy' => [
    'type' => HttpKernelInterface::class,
    'name' => 'app',
  ],
  'http_middleware.session' => [
    'type' => HttpKernelInterface::class,
    'name' => 'httpKernel',
  ],
  'image.factory' => [
    'type' => ImageFactory::class,
    'name' => 'imageFactory',
  ],
  'image.toolkit.manager' => [
    'type' => ImageToolkitManager::class,
    'name' => 'toolkitManager',
  ],
  'image.toolkit.operation.manager' => [
    'type' => PluginManagerInterface::class,
    'name' => 'imageToolkitOperationManager',
  ],
  'info_parser' => [
    'type' => InfoParserInterface::class,
    'name' => 'infoParser',
  ],
  'kernel' => [
    'type' => DrupalKernelInterface::class,
    'name' => 'drupalKernel',
  ],
  'kernel_destruct_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'kernelDestructSubscriber',
  ],
  'keyvalue' => [
    'type' => KeyValueFactoryInterface::class,
    'name' => 'keyValueFactory',
  ],
  'keyvalue.database' => [
    'type' => KeyValueFactoryInterface::class,
    'name' => 'keyvalueDatabase',
  ],
  'keyvalue.expirable' => [
    'type' => KeyValueExpirableFactoryInterface::class,
    'name' => 'keyValueExpirableFactory',
  ],
  'keyvalue.expirable.database' => [
    'type' => KeyValueExpirableFactoryInterface::class,
    'name' => 'keyvalueExpirableDatabase',
  ],
  'language.current_language_context' => [
    'type' => ContextProviderInterface::class,
    'name' => 'languageCurrentLanguageContext',
  ],
  'language.default' => [
    'type' => LanguageDefault::class,
    'name' => 'defaultLanguage',
  ],
  'language_manager' => [
    'type' => LanguageManagerInterface::class,
    'name' => 'languageManager',
  ],
  'library.dependency_resolver' => [
    'type' => LibraryDependencyResolverInterface::class,
    'name' => 'libraryDependencyResolver',
  ],
  'library.discovery' => [
    'type' => LibraryDiscoveryInterface::class,
    'name' => 'libraryDiscovery',
  ],
  'library.discovery.collector' => [
    'type' => CacheCollectorInterface::class,
    'name' => 'libraryDiscoveryCollector',
  ],
  'library.discovery.parser' => [
    'type' => LibraryDiscoveryParser::class,
    'name' => 'discoveryParser',
  ],
  'library.libraries_directory_file_finder' => [
    'type' => LibrariesDirectoryFileFinder::class,
    'name' => 'librariesDirectoryFileFinder',
  ],
  'link_generator' => [
    'type' => LinkGeneratorInterface::class,
    'name' => 'linkGenerator',
  ],
  'lock' => [
    'type' => LockBackendInterface::class,
    'name' => 'lock',
  ],
  'lock.persistent' => [
    'type' => LockBackendInterface::class,
    'name' => 'persistentLock',
  ],
  'logger.channel.contact' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.cron' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.default' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.file' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.form' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.image' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.php' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.security' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.system' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.channel.user' => [
    'type' => LoggerInterface::class,
    'name' => 'logger',
  ],
  'logger.dblog' => [
    'type' => LoggerInterface::class,
    'name' => 'loggerDblog',
  ],
  'logger.factory' => [
    'type' => LoggerChannelFactoryInterface::class,
    'name' => 'logger',
  ],
  'logger.log_message_parser' => [
    'type' => LogMessageParserInterface::class,
    'name' => 'parser',
  ],
  'main_content_renderer.ajax' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'ajaxRenderer',
  ],
  'main_content_renderer.dialog' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'mainContentRendererDialog',
  ],
  'main_content_renderer.html' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'mainContentRendererHtml',
  ],
  'main_content_renderer.modal' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'mainContentRendererModal',
  ],
  'main_content_renderer.off_canvas' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'mainContentRendererOffCanvas',
  ],
  'main_content_renderer.off_canvas_top' => [
    'type' => MainContentRendererInterface::class,
    'name' => 'mainContentRendererOffCanvasTop',
  ],
  'main_content_view_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'mainContentViewSubscriber',
  ],
  'maintenance_mode' => [
    'type' => MaintenanceModeInterface::class,
    'name' => 'maintenanceMode',
  ],
  'maintenance_mode_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'maintenanceModeSubscriber',
  ],
  'menu.active_trail' => [
    'type' => MenuActiveTrailInterface::class,
    'name' => 'menuActiveTrail',
  ],
  'menu.default_tree_manipulators' => [
    'type' => DefaultMenuLinkTreeManipulators::class,
    'name' => 'menuDefaultTreeManipulators',
  ],
  'menu.link_tree' => [
    'type' => MenuLinkTreeInterface::class,
    'name' => 'menuLinkTree',
  ],
  'menu.parent_form_selector' => [
    'type' => MenuParentFormSelectorInterface::class,
    'name' => 'menuParentFormSelector',
  ],
  'menu.rebuild_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'menuRebuildSubscriber',
  ],
  'menu_link.static.overrides' => [
    'type' => StaticMenuLinkOverridesInterface::class,
    'name' => 'overrides',
  ],
  'messenger' => [
    'type' => MessengerInterface::class,
    'name' => 'messenger',
  ],
  'method_filter' => [
    'type' => FilterInterface::class,
    'name' => 'methodFilter',
  ],
  'module_handler' => [
    'type' => ModuleHandlerInterface::class,
    'name' => 'moduleHandler',
  ],
  'module_required_by_themes_uninstall_validator' => [
    'type' => ConfigImportModuleUninstallValidatorInterface::class,
    'name' => 'moduleRequiredByThemesUninstallValidator',
  ],
  'node.admin_path.route_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'nodeAdminPathRouteSubscriber',
  ],
  'node.grant_storage' => [
    'type' => NodeGrantDatabaseStorageInterface::class,
    'name' => 'nodeGrantStorage',
  ],
  'node.node_route_context' => [
    'type' => ContextProviderInterface::class,
    'name' => 'nodeNodeRouteContext',
  ],
  'node.route_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'nodeRouteSubscriber',
  ],
  'node_preview' => [
    'type' => ParamConverterInterface::class,
    'name' => 'nodePreview',
  ],
  'options_request_listener' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'optionsRequestListener',
  ],
  'page_cache_kill_switch' => [
    'type' => KillSwitch::class,
    'name' => 'killSwitch',
  ],
  'page_cache_request_policy' => [
    'type' => RequestPolicyInterface::class,
    'name' => 'requestPolicy',
  ],
  'page_cache_response_policy' => [
    'type' => ResponsePolicyInterface::class,
    'name' => 'responsePolicy',
  ],
  'pager.manager' => [
    'type' => PagerManagerInterface::class,
    'name' => 'pagerManager',
  ],
  'pager.parameters' => [
    'type' => PagerParametersInterface::class,
    'name' => 'pagerParams',
  ],
  'paramconverter.configentity_admin' => [
    'type' => ParamConverterInterface::class,
    'name' => 'paramconverterConfigentityAdmin',
  ],
  'paramconverter.entity' => [
    'type' => ParamConverterInterface::class,
    'name' => 'paramconverterEntity',
  ],
  'paramconverter.entity_revision' => [
    'type' => ParamConverterInterface::class,
    'name' => 'paramconverterEntityRevision',
  ],
  'paramconverter.menu_link' => [
    'type' => ParamConverterInterface::class,
    'name' => 'paramconverterMenuLink',
  ],
  'paramconverter.views_ui' => [
    'type' => ParamConverterInterface::class,
    'name' => 'paramconverterViewsUi',
  ],
  'paramconverter_manager' => [
    'type' => ParamConverterManagerInterface::class,
    'name' => 'paramConverterManager',
  ],
  'paramconverter_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'paramconverterSubscriber',
  ],
  'password' => [
    'type' => PasswordInterface::class,
    'name' => 'passwordChecker',
  ],
  'password_generator' => [
    'type' => PasswordGeneratorInterface::class,
    'name' => 'passwordGenerator',
  ],
  'path.current' => [
    'type' => CurrentPathStack::class,
    'name' => 'currentPath',
  ],
  'path.matcher' => [
    'type' => PathMatcherInterface::class,
    'name' => 'pathMatcher',
  ],
  'path.validator' => [
    'type' => PathValidatorInterface::class,
    'name' => 'pathValidator',
  ],
  'path_alias.manager' => [
    'type' => AliasManagerInterface::class,
    'name' => 'aliasManager',
  ],
  'path_alias.path_processor' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathAliasPathProcessor',
  ],
  'path_alias.repository' => [
    'type' => AliasRepositoryInterface::class,
    'name' => 'aliasRepository',
  ],
  'path_alias.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'pathAliasSubscriber',
  ],
  'path_alias.whitelist' => [
    'type' => CacheCollectorInterface::class,
    'name' => 'pathAliasWhitelist',
  ],
  'path_processor.files' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathProcessorFiles',
  ],
  'path_processor.image_styles' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathProcessorImageStyles',
  ],
  'path_processor_decode' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathProcessorDecode',
  ],
  'path_processor_front' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathProcessorFront',
  ],
  'path_processor_manager' => [
    'type' => InboundPathProcessorInterface::class,
    'name' => 'pathProcessor',
  ],
  'pgsql.entity.query.sql' => [
    'type' => QueryFactoryInterface::class,
    'name' => 'pgsqlEntityQuerySql',
  ],
  'placeholder_strategy' => [
    'type' => PlaceholderStrategyInterface::class,
    'name' => 'placeholderStrategy',
  ],
  'placeholder_strategy.big_pipe' => [
    'type' => PlaceholderStrategyInterface::class,
    'name' => 'placeholderStrategyBigPipe',
  ],
  'placeholder_strategy.single_flush' => [
    'type' => PlaceholderStrategyInterface::class,
    'name' => 'placeholderStrategySingleFlush',
  ],
  'plugin.cache_clearer' => [
    'type' => CachedDiscoveryClearerInterface::class,
    'name' => 'pluginCacheClearer',
  ],
  'plugin.manager.action' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerAction',
  ],
  'plugin.manager.archiver' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerArchiver',
  ],
  'plugin.manager.block' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerBlock',
  ],
  'plugin.manager.ckeditor.plugin' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerCkeditorPlugin',
  ],
  'plugin.manager.condition' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerCondition',
  ],
  'plugin.manager.display_variant' => [
    'type' => PluginManagerInterface::class,
    'name' => 'displayVariantManager',
  ],
  'plugin.manager.editor' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManager',
  ],
  'plugin.manager.element_info' => [
    'type' => ElementInfoManagerInterface::class,
    'name' => 'elementInfo',
  ],
  'plugin.manager.entity_reference_selection' => [
    'type' => SelectionPluginManagerInterface::class,
    'name' => 'selectionManager',
  ],
  'plugin.manager.field.field_type' => [
    'type' => FieldTypePluginManagerInterface::class,
    'name' => 'fieldTypeManager',
  ],
  'plugin.manager.field.formatter' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerFieldFormatter',
  ],
  'plugin.manager.field.widget' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerFieldWidget',
  ],
  'plugin.manager.filter' => [
    'type' => PluginManagerInterface::class,
    'name' => 'filterManager',
  ],
  'plugin.manager.help_section' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerHelpSection',
  ],
  'plugin.manager.image.effect' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerImageEffect',
  ],
  'plugin.manager.link_relation_type' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerLinkRelationType',
  ],
  'plugin.manager.mail' => [
    'type' => MailManagerInterface::class,
    'name' => 'mailManager',
  ],
  'plugin.manager.menu.contextual_link' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerMenuContextualLink',
  ],
  'plugin.manager.menu.link' => [
    'type' => MenuLinkManagerInterface::class,
    'name' => 'menuLinkManager',
  ],
  'plugin.manager.menu.local_action' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerMenuLocalAction',
  ],
  'plugin.manager.menu.local_task' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerMenuLocalTask',
  ],
  'plugin.manager.queue_worker' => [
    'type' => QueueWorkerManagerInterface::class,
    'name' => 'queueManager',
  ],
  'plugin.manager.search' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerSearch',
  ],
  'plugin.manager.tour.tip' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerTourTip',
  ],
  'plugin.manager.views.access' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsAccess',
  ],
  'plugin.manager.views.area' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsArea',
  ],
  'plugin.manager.views.argument' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsArgument',
  ],
  'plugin.manager.views.argument_default' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsArgumentDefault',
  ],
  'plugin.manager.views.argument_validator' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsArgumentValidator',
  ],
  'plugin.manager.views.cache' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsCache',
  ],
  'plugin.manager.views.display' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsDisplay',
  ],
  'plugin.manager.views.display_extender' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsDisplayExtender',
  ],
  'plugin.manager.views.exposed_form' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsExposedForm',
  ],
  'plugin.manager.views.field' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsField',
  ],
  'plugin.manager.views.filter' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsFilter',
  ],
  'plugin.manager.views.join' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsJoin',
  ],
  'plugin.manager.views.pager' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsPager',
  ],
  'plugin.manager.views.query' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsQuery',
  ],
  'plugin.manager.views.relationship' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsRelationship',
  ],
  'plugin.manager.views.row' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsRow',
  ],
  'plugin.manager.views.sort' => [
    'type' => PluginManagerInterface::class,
    'name' => 'pluginManagerViewsSort',
  ],
  'plugin.manager.views.style' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsStyle',
  ],
  'plugin.manager.views.wizard' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'pluginManagerViewsWizard',
  ],
  'plugin_form.factory' => [
    'type' => PluginFormFactoryInterface::class,
    'name' => 'pluginFormFactory',
  ],
  'private_key' => [
    'type' => PrivateKey::class,
    'name' => 'privateKey',
  ],
  'psr7.http_foundation_factory' => [
    'type' => HttpFoundationFactoryInterface::class,
    'name' => 'httpFoundationFactory',
  ],
  'psr7.http_message_factory' => [
    'type' => HttpMessageFactoryInterface::class,
    'name' => 'httpMessageFactory',
  ],
  'psr_response_view_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'psrResponseViewSubscriber',
  ],
  'queue' => [
    'type' => QueueFactory::class,
    'name' => 'queueFactory',
  ],
  'queue.database' => [
    'type' => QueueDatabaseFactory::class,
    'name' => 'queueDatabase',
  ],
  'redirect.destination' => [
    'type' => RedirectDestinationInterface::class,
    'name' => 'redirectDestination',
  ],
  'redirect_leading_slashes_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'redirectLeadingSlashesSubscriber',
  ],
  'redirect_response_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'redirectResponseSubscriber',
  ],
  'render_cache' => [
    'type' => RenderCacheInterface::class,
    'name' => 'renderCache',
  ],
  'render_placeholder_generator' => [
    'type' => PlaceholderGeneratorInterface::class,
    'name' => 'placeholderGenerator',
  ],
  'renderer' => [
    'type' => RendererInterface::class,
    'name' => 'renderer',
  ],
  'renderer_non_html' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'rendererNonHtml',
  ],
  'request_close_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'requestCloseSubscriber',
  ],
  'request_format_route_filter' => [
    'type' => FilterInterface::class,
    'name' => 'requestFormatRouteFilter',
  ],
  'request_stack' => [
    'type' => RequestStack::class,
    'name' => 'requestStack',
  ],
  'required_module_uninstall_validator' => [
    'type' => ModuleUninstallValidatorInterface::class,
    'name' => 'requiredModuleUninstallValidator',
  ],
  'resolver_manager.entity' => [
    'type' => EntityResolverManager::class,
    'name' => 'entityResolverManager',
  ],
  'response_filter.active_link' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'responseFilterActiveLink',
  ],
  'response_filter.rss.relative_url' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'responseFilterRssRelativeUrl',
  ],
  'response_generator_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'responseGeneratorSubscriber',
  ],
  'route_access_response_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeAccessResponseSubscriber',
  ],
  'route_enhancer.entity' => [
    'type' => EnhancerInterface::class,
    'name' => 'routeEnhancerEntity',
  ],
  'route_enhancer.entity_bundle' => [
    'type' => EnhancerInterface::class,
    'name' => 'routeEnhancerEntityBundle',
  ],
  'route_enhancer.entity_revision' => [
    'type' => EnhancerInterface::class,
    'name' => 'routeEnhancerEntityRevision',
  ],
  'route_enhancer.form' => [
    'type' => EnhancerInterface::class,
    'name' => 'routeEnhancerForm',
  ],
  'route_enhancer.param_conversion' => [
    'type' => EnhancerInterface::class,
    'name' => 'routeEnhancerParamConversion',
  ],
  'route_http_method_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeHttpMethodSubscriber',
  ],
  'route_processor_csrf' => [
    'type' => OutboundRouteProcessorInterface::class,
    'name' => 'routeProcessorCsrf',
  ],
  'route_processor_current' => [
    'type' => OutboundRouteProcessorInterface::class,
    'name' => 'routeProcessorCurrent',
  ],
  'route_processor_manager' => [
    'type' => OutboundRouteProcessorInterface::class,
    'name' => 'routeProcessorManager',
  ],
  'route_special_attributes_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeSpecialAttributesSubscriber',
  ],
  'route_subscriber.entity' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeSubscriberEntity',
  ],
  'route_subscriber.module' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeSubscriberModule',
  ],
  'route_subscriber.no_big_pipe' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routeSubscriberNoBigPipe',
  ],
  'router' => [
    'type' => AccessAwareRouterInterface::class,
    'name' => 'accessAwareRouter',
  ],
  'router.admin_context' => [
    'type' => AdminContext::class,
    'name' => 'adminContext',
  ],
  'router.builder' => [
    'type' => RouteBuilderInterface::class,
    'name' => 'routeBuilder',
  ],
  'router.dumper' => [
    'type' => MatcherDumperInterface::class,
    'name' => 'dumper',
  ],
  'router.no_access_checks' => [
    'type' => UrlMatcherInterface::class,
    'name' => 'accessUnawareRouter',
  ],
  'router.path_roots_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routerPathRootsSubscriber',
  ],
  'router.request_context' => [
    'type' => RequestContext::class,
    'name' => 'requestContext',
  ],
  'router.route_preloader' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routerRoutePreloader',
  ],
  'router.route_provider' => [
    'type' => RouteProviderInterface::class,
    'name' => 'routeProvider',
  ],
  'router.route_provider.lazy_builder' => [
    'type' => PreloadableRouteProviderInterface::class,
    'name' => 'routerRouteProviderLazyBuilder',
  ],
  'router_listener' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'routerListener',
  ],
  'search.index' => [
    'type' => SearchIndexInterface::class,
    'name' => 'searchIndex',
  ],
  'search.search_page_repository' => [
    'type' => SearchPageRepositoryInterface::class,
    'name' => 'searchSearchPageRepository',
  ],
  'search.text_processor' => [
    'type' => SearchTextProcessorInterface::class,
    'name' => 'textProcessor',
  ],
  'serialization.json' => [
    'type' => SerializationInterface::class,
    'name' => 'serializationJson',
  ],
  'serialization.phpserialize' => [
    'type' => SerializationInterface::class,
    'name' => 'serializer',
  ],
  'serialization.yaml' => [
    'type' => SerializationInterface::class,
    'name' => 'serializationYaml',
  ],
  'service_container' => [
    'type' => ContainerInterface::class,
    'name' => 'container',
  ],
  'session' => [
    'type' => SessionInterface::class,
    'name' => 'session',
  ],
  'session_configuration' => [
    'type' => SessionConfigurationInterface::class,
    'name' => 'sessionConfiguration',
  ],
  'session_handler.storage' => [
    'type' => \SessionHandlerInterface::class,
    'name' => 'wrappedSessionHandler',
  ],
  'session_handler.write_safe' => [
    'type' => WriteSafeSessionHandlerInterface::class,
    'name' => 'writeSafeHandler',
  ],    
  'session_manager.metadata_bag' => [
    'type' => MetadataBag::class,
    'name' => 'sessionMetadata',
  ],    
  'settings' => [
    'type' => Settings::class,
    'name' => 'settings',
  ],    
  'shortcut.lazy_builders' => [
    'type' => TrustedCallbackInterface::class,
    'name' => 'shortcutLazyBuilders',
  ],    
  'state' => [
    'type' => StateInterface::class,
    'name' => 'state',
  ],    
  'stream_wrapper.public' => [
    'type' => PhpStreamWrapperInterface::class,
    'name' => 'streamWrapperPublic',
  ],    
  'stream_wrapper.temporary' => [
    'type' => PhpStreamWrapperInterface::class,
    'name' => 'streamWrapperTemporary',
  ],    
  'stream_wrapper_manager' => [
    'type' => StreamWrapperManagerInterface::class,
    'name' => 'streamWrapperManager',
  ],    
  'string_translation' => [
    'type' => TranslationInterface::class,
    'name' => 'stringTranslation',
  ],    
  'string_translator.custom_strings' => [
    'type' => TranslatorInterface::class,
    'name' => 'stringTranslatorCustomStrings',
  ],    
  'system.admin_path.route_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemAdminPathRouteSubscriber',
  ],    
  'system.advisories_config_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemAdvisoriesConfigSubscriber',
  ],    
  'system.breadcrumb.default' => [
    'type' => BreadcrumbBuilderInterface::class,
    'name' => 'systemBreadcrumbDefault',
  ],    
  'system.config_cache_tag' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemConfigCacheTag',
  ],    
  'system.config_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemConfigSubscriber',
  ],    
  'system.file_event.subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemFileEventSubscriber',
  ],    
  'system.manager' => [
    'type' => SystemManager::class,
    'name' => 'systemManager',
  ],    
  'system.sa_fetcher' => [
    'type' => SecurityAdvisoriesFetcher::class,
    'name' => 'securityAdvisoriesFetcher',
  ],    
  'system.timezone_resolver' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'systemTimezoneResolver',
  ],    
  'taxonomy_term.breadcrumb' => [
    'type' => BreadcrumbBuilderInterface::class,
    'name' => 'taxonomyTermBreadcrumb',
  ],    
  'taxonomy_term.taxonomy_term_route_context' => [
    'type' => ContextProviderInterface::class,
    'name' => 'taxonomyTermTaxonomyTermRouteContext',
  ],    
  'tempstore.private' => [
    'type' => PrivateTempStoreFactory::class,
    'name' => 'tempStoreFactory',
  ],    
  'tempstore.shared' => [
    'type' => SharedTempStoreFactory::class,
    'name' => 'tempStoreFactory',
  ],    
  'theme.initialization' => [
    'type' => ThemeInitializationInterface::class,
    'name' => 'themeInitialization',
  ],    
  'theme.manager' => [
    'type' => ThemeManagerInterface::class,
    'name' => 'themeManager',
  ],    
  'theme.negotiator' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiator',
  ],    
  'theme.negotiator.admin_theme' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorAdminTheme',
  ],    
  'theme.negotiator.ajax_base_page' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorAjaxBasePage',
  ],    
  'theme.negotiator.block.admin_demo' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorBlockAdminDemo',
  ],    
  'theme.negotiator.default' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorDefault',
  ],    
  'theme.negotiator.system.batch' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorSystemBatch',
  ],    
  'theme.negotiator.system.db_update' => [
    'type' => ThemeNegotiatorInterface::class,
    'name' => 'themeNegotiatorSystemDbUpdate',
  ],    
  'theme.registry' => [
    'type' => Registry::class,
    'name' => 'themeRegistry',
  ],    
  'theme_handler' => [
    'type' => ThemeHandlerInterface::class,
    'name' => 'themeHandler',
  ],    
  'theme_installer' => [
    'type' => ThemeInstallerInterface::class,
    'name' => 'themeInstaller',
  ],    
  'title_resolver' => [
    'type' => TitleResolverInterface::class,
    'name' => 'titleResolver',
  ],    
  'token' => [
    'type' => Token::class,
    'name' => 'token',
  ],    
  'toolbar.page_cache_request_policy.allow_toolbar_path' => [
    'type' => RequestPolicyInterface::class,
    'name' => 'toolbarPageCacheRequestPolicyAllowToolbarPath',
  ],    
  'transliteration' => [
    'type' => TransliterationInterface::class,
    'name' => 'transliteration',
  ],    
  'twig.extension' => [
    'type' => ExtensionInterface::class,
    'name' => 'twigExtension',
  ],    
  'twig.extension.debug' => [
    'type' => ExtensionInterface::class,
    'name' => 'twigExtensionDebug',
  ],
  'twig.loader.filesystem' => [
    'type' => LoaderInterface::class,
    'name' => 'twigLoaderFilesystem',
  ],    
  'twig.loader.string' => [
    'type' => LoaderInterface::class,
    'name' => 'twigLoaderString',
  ],    
  'twig.loader.theme_registry' => [
    'type' => LoaderInterface::class,
    'name' => 'twigLoaderThemeRegistry',
  ],    
  'typed_data_manager' => [
    'type' => TypedDataManagerInterface::class,
    'name' => 'typedDataManager',
  ],    
  'unrouted_url_assembler' => [
    'type' => UnroutedUrlAssemblerInterface::class,
    'name' => 'urlAssembler',
  ],    
  'update.fetcher' => [
    'type' => UpdateFetcherInterface::class,
    'name' => 'updateFetcher',
  ],    
  'update.manager' => [
    'type' => UpdateManagerInterface::class,
    'name' => 'updateManager',
  ],    
  'update.post_update_registry' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'updatePostUpdateRegistry',
  ],    
  'update.post_update_registry_factory' => [
    'type' => ContainerAwareInterface::class,
    'name' => 'updatePostUpdateRegistryFactory',
  ],    
  'update.processor' => [
    'type' => UpdateProcessorInterface::class,
    'name' => 'updateProcessor',
  ],    
  'update.update_hook_registry' => [
    'type' => UpdateHookRegistry::class,
    'name' => 'updateUpdateHookRegistry',
  ],    
  'update.update_hook_registry_factory' => [
    'type' => ContainerAwareInterface::class,
    'name' => 'updateUpdateHookRegistryFactory',
  ],    
  'url_generator' => [
    'type' => UrlGeneratorInterface::class,
    'name' => 'urlGenerator',
  ],    
  'user.auth' => [
    'type' => UserAuthInterface::class,
    'name' => 'userAuth',
  ],    
  'user.authentication.cookie' => [
    'type' => AuthenticationProviderInterface::class,
    'name' => 'userAuthenticationCookie',
  ],    
  'user.current_user_context' => [
    'type' => ContextProviderInterface::class,
    'name' => 'userCurrentUserContext',
  ],    
  'user.data' => [
    'type' => UserDataInterface::class,
    'name' => 'userData',
  ],    
  'user.flood_control' => [
    'type' => UserFloodControlInterface::class,
    'name' => 'userFloodControl',
  ],    
  'user.flood_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'userFloodSubscriber',
  ],    
  'user.permissions' => [
    'type' => PermissionHandlerInterface::class,
    'name' => 'userPermissions',
  ],    
  'user.toolbar_link_builder' => [
    'type' => TrustedCallbackInterface::class,
    'name' => 'userToolbarLinkBuilder',
  ],    
  'user_access_denied_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'userAccessDeniedSubscriber',
  ],    
  'user_last_access_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'userLastAccessSubscriber',
  ],    
  'user_maintenance_mode_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'userMaintenanceModeSubscriber',
  ],    
  'user_permissions_hash_generator' => [
    'type' => PermissionsHashGeneratorInterface::class,
    'name' => 'permissionsHashGenerator',
  ],    
  'uuid' => [
    'type' => UuidInterface::class,
    'name' => 'uuid',
  ],    
  'validation.constraint' => [
    'type' => CacheableDependencyInterface::class,
    'name' => 'validationConstraint',
  ],    
  'views.analyzer' => [
    'type' => Analyzer::class,
    'name' => 'viewsAnalyzer',
  ],    
  'views.date_sql' => [
    'type' => DateSqlInterface::class,
    'name' => 'viewsDateSql',
  ],    
  'views.entity_schema_subscriber' => [
    'type' => EntityTypeListenerInterface::class,
    'name' => 'viewsEntitySchemaSubscriber',
  ],    
  'views.executable' => [
    'type' => ViewExecutableFactory::class,
    'name' => 'viewsExecutable',
  ],    
  'views.exposed_form_cache' => [
    'type' => ExposedFormCache::class,
    'name' => 'viewsExposedFormCache',
  ],    
  'views.route_subscriber' => [
    'type' => EventSubscriberInterface::class,
    'name' => 'viewsRouteSubscriber',
  ],    
  'views.views_data' => [
    'type' => ViewsData::class,
    'name' => 'viewsData',
  ],    
  'views.views_data_helper' => [
    'type' => ViewsDataHelper::class,
    'name' => 'viewsViewsDataHelper',
  ],    
];
