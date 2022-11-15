<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\Site\Settings;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'phpstorm-meta',
  description: 'Generates PhpStorm metadata',
  templatePath: Application::TEMPLATE_PATH . '/_phpstorm-meta',
  type: GeneratorType::OTHER,
  label: 'PhpStorm metadata',
)]
final class PhpStormMeta extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly EntityTypeBundleInfoInterface $entityTypeBundleInfo,
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFieldManagerInterface $entityFieldManager,
    private readonly KeyValueFactoryInterface $keyValueStore,
    private readonly FieldTypePluginManagerInterface $fieldTypePluginManager,
    private readonly ModuleHandlerInterface $moduleHandler,
    private readonly ThemeHandlerInterface $themeHandler,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.bundle.info'),
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('keyvalue'),
      $container->get('plugin.manager.field.field_type'),
      $container->get('module_handler'),
      $container->get('theme_handler'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $this->generatePlugins($assets);
    $this->generateDateFormats($assets);
    $this->generateEntityBundles($assets);
    $this->generateEntityLinks($assets);
    $this->generateEntityTypes($assets);
    $this->generateExtensions($assets);
    $this->generateFields($assets);
    $this->generateFieldDefinitions($assets);
    $this->generateServices($assets);
    $this->generateRoutes($assets);
    $this->generateConfiguration($assets);
    $this->generateRoles($assets);
    $this->generatePermissions($assets);
    $this->generateSettings($assets);
    $this->generateStates($assets);
    $this->generateFileSystem($assets);
    $this->generateMiscellaneous($assets);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDestination(array $vars): ?string {
    // Typically the root of the PhpStorm project is one level above of the
    // Drupal root.
    if (!\file_exists(\DRUPAL_ROOT . '/.idea') && \file_exists(\DRUPAL_ROOT . '/../.idea')) {
      return \DRUPAL_ROOT . '/..';
    }
    return \DRUPAL_ROOT;
  }

  /**
   * Adds slash to class name.
   */
  private static function addSlash(string &$class): void {
    if (!\str_starts_with($class, '\\')) {
      $class = '\\' . $class;
    }
  }

  /**
   * Returns entity interface for a given entity type.
   */
  private static function getEntityInterface(EntityTypeInterface $definition): ?string {
    $class = $definition->getClass();
    self::addSlash($class);
    // Most of content entity types implement an interface which name follows
    // this pattern.
    $interface = \str_replace('\Entity\\', '\\', $class) . 'Interface';
    return $definition->entityClassImplements($interface) ? $interface : NULL;
  }

  private function generateConfiguration(Assets $assets): void {
    $configs = $this->getHelper('config_info')->getConfigNames();
    $assets->addFile('.phpstorm.meta.php/configuration.php', 'configuration.php.twig')
      ->vars(['configs' => $configs]);
  }

  private function generateDateFormats(Assets $assets): void {
    $date_formats = $this->entityTypeManager->getStorage('date_format')->loadMultiple();
    $date_formats['custom'] = NULL;
    $assets->addFile('.phpstorm.meta.php/date_formats.php', 'date_formats.php.twig')
      ->vars(['date_formats' => \array_keys($date_formats)]);
  }

  private function generateEntityLinks(Assets $assets): void {
    $definitions = [];
    foreach ($this->entityTypeManager->getDefinitions() as $entity_type => $definition) {
      $class = $definition->getClass();
      self::addSlash($class);
      $definitions[] = [
        'type' => $entity_type,
        'label' => $definition->getLabel(),
        'class' => $class,
        'interface' => self::getEntityInterface($definition),
        'links' => \array_keys($definition->getLinkTemplates()),
      ];
    }
    \asort($definitions);
    $assets->addFile('.phpstorm.meta.php/entity_links.php', 'entity_links.php.twig')
      ->vars(['definitions' => $definitions]);
  }

  private function generateEntityBundles(Assets $assets): void {
    $definitions = [];
    $entity_definitions = $this->entityTypeManager->getDefinitions();
    \ksort($entity_definitions);
    $bundle_getters = [
      'node' => 'getType',
      'comment' => 'getTypeId',
    ];
    foreach ($entity_definitions as $entity_type_id => $entity_definition) {
      $class = $entity_definition->getClass();
      self::addSlash($class);
      $definitions[] = [
        'type' => $entity_type_id,
        'label' => $entity_definition->getLabel(),
        'class' => $class,
        'interface' => self::getEntityInterface($entity_definition),
        'bundle_getter' => $bundle_getters[$entity_type_id] ?? NULL,
        'bundles' => \array_keys($this->entityTypeBundleInfo->getBundleInfo($entity_type_id)),
      ];
    }
    $assets->addFile('.phpstorm.meta.php/entity_bundles.php', 'entity_bundles.php.twig')
      ->vars(['definitions' => $definitions]);
  }

  private function generateEntityTypes(Assets $assets): void {
    $entity_types = [];
    $handlers['storages'] = [];
    $handlers['view_builders'] = [];
    $handlers['list_builders'] = [];
    $handlers['access_controls'] = [];
    $handlers['classes'] = [];
    $definitions = $this->entityTypeManager->getDefinitions();
    \ksort($definitions);
    foreach ($definitions as $type => $definition) {
      $entity_types[] = $type;
      $handlers['classes'][] = $definition->getClass();
      $handlers['storages'][$type] = $definition->getStorageClass();
      $handlers['access_controls'][$type] = $definition->getAccessControlClass();
      if ($definition->hasViewBuilderClass()) {
        $handlers['view_builders'][$type] = $definition->getViewBuilderClass();
      }
      if ($definition->hasListBuilderClass()) {
        $handlers['list_builders'][$type] = $definition->getListBuilderClass();
      }
    }
    // Some classes do not have leading slash.
    \array_walk_recursive($handlers, [self::class, 'addSlash']);

    $assets->addFile('.phpstorm.meta.php/entity_types.php', 'entity_types.php.twig')
      ->vars(['handlers' => $handlers, 'entity_types' => $entity_types]);
  }

  private function generateExtensions(Assets $assets): void {
    $module_extensions = \array_filter(
      $this->moduleHandler->getModuleList(),
      static fn (Extension $extension): bool => $extension->getType() === 'module',
    );
    $modules = \array_keys($module_extensions);
    $themes = \array_keys($this->themeHandler->listInfo());
    \sort($themes);
    $assets->addFile('.phpstorm.meta.php/extensions.php', 'extensions.php.twig')
      ->vars(['modules' => $modules, 'themes' => $themes]);
  }

  private function generateFields(Assets $assets): void {
    $definitions = [];
    foreach ($this->entityTypeManager->getDefinitions() as $entity_type => $definition) {
      if (!$definition->entityClassImplements(FieldableEntityInterface::class)) {
        continue;
      }
      $class = $definition->getClass();
      self::addSlash($class);
      $definitions[] = [
        'type' => $entity_type,
        'label' => $definition->getLabel(),
        'class' => $class,
        'interface' => self::getEntityInterface($definition),
        'fields' => \array_keys($this->entityFieldManager->getFieldStorageDefinitions($entity_type)),
      ];
    }
    $assets->addFile('.phpstorm.meta.php/fields.php', 'fields.php.twig')
      ->vars(['definitions' => $definitions]);
  }

  private function generateFieldDefinitions(Assets $assets): void {
    $entity_types = \array_keys($this->entityTypeManager->getDefinitions());
    \sort($entity_types);
    $field_types = \array_keys($this->fieldTypePluginManager->getDefinitions());
    \sort($field_types);

    $assets->addFile('.phpstorm.meta.php/field_definitions.php', 'field_definitions.php.twig')
      ->vars(['entity_types' => $entity_types, 'field_types' => $field_types]);
  }

  private function generateFileSystem(Assets $assets): void {
    $assets->addFile('.phpstorm.meta.php/file_system.php', 'file_system.php.twig');
  }

  private function generateMiscellaneous(Assets $assets): void {
    $assets->addFile('.phpstorm.meta.php/miscellaneous.php', 'miscellaneous.php.twig');
  }

  private function generatePermissions(Assets $assets): void {
    $permissions = $this->getHelper('permission_info')->getPermissionNames();
    $assets->addFile('.phpstorm.meta.php/permissions.php', 'permissions.php.twig')
      ->vars(['permissions' => $permissions]);
  }

  private function generatePlugins(Assets $assets): void {
    $plugins = [
      '\Drupal\Core\Action\ActionManager' => '\Drupal\Core\Action\ActionInterface',
      '\Drupal\Core\Archiver\ArchiverManager' => '\Drupal\Core\Archiver\ArchiverInterface',
      '\Drupal\Core\Block\BlockManagerInterface' => '\Drupal\Core\Block\BlockPluginInterface',
      '\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface',
      '\Drupal\Core\Condition\ConditionManager' => '\Drupal\Core\Condition\ConditionInterface',
      '\Drupal\Core\Display\VariantManager' => '\Drupal\Core\Display\VariantInterface',
      '\Drupal\editor\Plugin\EditorManager' => '\Drupal\editor\Plugin\EditorPluginInterface',
      '\Drupal\Core\Render\ElementInfoManagerInterface' => '\Drupal\Core\Render\Element\ElementInterface',
      '\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface',
      '\Drupal\Core\Field\FieldTypePluginManagerInterface' => '\Drupal\Core\Field\FieldItemInterface',
      '\Drupal\Core\Field\FormatterPluginManager' => '\Drupal\Core\Field\FormatterInterface',
      '\Drupal\Core\Field\WidgetPluginManager' => '\Drupal\Core\Field\WidgetInterface',
      '\Drupal\filter\FilterPluginManager' => '\Drupal\filter\Plugin\FilterInterface',
      '\Drupal\help\HelpSectionManager' => '\Drupal\help\HelpSectionPluginInterface',
      '\Drupal\image\ImageEffectManager' => '\Drupal\image\ImageEffectInterface',
      '\\Drupal\Core\Http\LinkRelationTypeManager' => '\Drupal\Core\Http\LinkRelationTypeInterface',
      '\Drupal\Core\Mail\MailManagerInterface' => '\Drupal\Core\Mail\MailInterface',
      '\Drupal\Core\Menu\ContextualLinkManagerInterface' => '\Drupal\Core\Menu\ContextualLinkInterface',
      '\Drupal\Core\Menu\LocalActionManager' => '\Drupal\Core\Menu\LocalActionInterface',
      '\Drupal\Core\Menu\LocalActionManagerInterface' => '\Drupal\Core\Menu\LocalTaskInterface',
      '\Drupal\Core\Menu\MenuLinkManagerInterface' => '\Drupal\Core\Menu\MenuLinkInterface',
      '\Drupal\Core\Queue\QueueWorkerManagerInterface' => '\Drupal\Core\Queue\QueueWorkerInterface',
      '\Drupal\search\SearchPluginManager' => '\Drupal\search\Plugin\SearchInterface',
      '\Drupal\tour\TipPluginManager' => '\Drupal\tour\TipPluginInterface',
    ];
    $assets->addFile('.phpstorm.meta.php/plugins.php', 'plugins.php.twig')
      ->vars(['plugins' => $plugins]);
  }

  private function generateRoles(Assets $assets): void {
    $roles = $this->entityTypeManager->getStorage('user_role')->loadMultiple();
    $assets->addFile('.phpstorm.meta.php/roles.php', 'roles.php.twig')
      // @todo Create a helper for roles.
      ->vars(['roles' => \array_keys($roles)]);
  }

  private function generateRoutes(Assets $assets): void {
    $routes = $this->getHelper('route_info')->getRouteNames();
    $assets->addFile('.phpstorm.meta.php/routes.php', 'routes.php.twig')
      ->vars(['routes' => $routes]);
  }

  private function generateServices(Assets $assets): void {
    $services = [];
    $service_definitions = $this->getHelper('service_info')->getServiceDefinitions();
    foreach ($service_definitions as $service_id => $service_definition) {
      if (isset($service_definition['class'])) {
        $services[$service_id] = $service_definition['class'];
      }
    }
    \array_walk($services, [self::class, 'addSlash']);
    \ksort($services);
    $assets->addFile('.phpstorm.meta.php/services.php', 'services.php.twig')
      ->vars(['services' => $services]);
  }

  private function generateSettings(Assets $assets): void {
    $assets->addFile('.phpstorm.meta.php/settings.php', 'settings.php.twig')
      ->vars(['settings' => \array_keys(Settings::getAll())]);
  }

  private function generateStates(Assets $assets): void {
    $assets->addFile('.phpstorm.meta.php/states.php', 'states.php.twig')
      ->vars(['states' => \array_keys($this->keyValueStore->get('state')->getAll())]);
  }

}
