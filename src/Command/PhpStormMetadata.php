<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\Site\Settings;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'phpstorm-metadata',
  description: 'Generates PhpStorm metadata',
  aliases: ['phpstorm-meta', 'phpstorm-data'],
  templatePath: Application::TEMPLATE_PATH . '/phpstorm-metadata',
  type: GeneratorType::OTHER,
  label: 'PhpStorm metadata',
)]
final class PhpStormMetadata extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFieldManagerInterface $entityFieldManager,
    private readonly KeyValueFactoryInterface $keyValueStore,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('keyvalue'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $this->generatePlugins($assets);
    $this->generateDateFormats($assets);
    $this->generateEntityLinks($assets);
    $this->generateEntityTypes($assets);
    $this->generateFields($assets);
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

  private function generateEntityTypes(Assets $assets): void {
    $entity_types['storages'] = [];
    $entity_types['view_builders'] = [];
    $entity_types['list_builders'] = [];
    $entity_types['access_controls'] = [];
    $entity_types['classes'] = [];
    foreach ($this->entityTypeManager->getDefinitions() as $type => $definition) {
      $entity_types['classes'][] = $definition->getClass();
      $entity_types['storages'][$type] = $definition->getStorageClass();
      $entity_types['access_controls'][$type] = $definition->getAccessControlClass();
      if ($definition->hasViewBuilderClass()) {
        $entity_types['view_builders'][$type] = $definition->getViewBuilderClass();
      }
      if ($definition->hasListBuilderClass()) {
        $entity_types['list_builders'][$type] = $definition->getListBuilderClass();
      }
    }
    // Some classes do not have leading slash.
    \array_walk_recursive($entity_types, [self::class, 'addSlash']);

    $sort = static function (array &$items): void {
      \ksort($items);
    };
    \array_walk($entity_types, $sort);

    $assets->addFile('.phpstorm.meta.php/entity_types.php', 'entity_types.php.twig')
      ->vars(['entity_types' => $entity_types]);
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
    // It's tricky to get the interfaces automatically as the
    // PluginManagerBase::getFactory() method is protected. Here is a code
    // snippet to obtain classes of plugin managers. The supported plugin
    // interface needs to be checked manually for each plugin manager.
    // @code
    //   $plugin_managers = \array_filter(
    //     $vars['services'],
    //     static fn (string $class): bool
    //       => \is_subclass_of($class, PluginManagerInterface::class),
    //   );
    // @endcode
    //
    // Note that \Drupal\views\Plugin\ViewsPluginManager class is not listed
    // here as it is used by multiple plugin mangers.
    $plugins = [
      '\Drupal\Core\Action\ActionManager' => '\Drupal\Core\Action\ActionInterface',
      '\Drupal\Core\Archiver\ArchiverManager' => '\Drupal\Core\Archiver\ArchiverInterface',
      '\Drupal\Core\Block\BlockManager' => '\Drupal\Core\Block\BlockPluginInterface',
      '\Drupal\ckeditor5\Plugin\CKEditor5PluginManager' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface',
      '\Drupal\Core\Condition\ConditionManager' => '\Drupal\Core\Condition\ConditionInterface',
      '\Drupal\Core\Display\VariantManager' => '\Drupal\Core\Display\VariantInterface',
      '\Drupal\editor\Plugin\EditorManager' => '\Drupal\editor\Plugin\EditorPluginInterface',
      '\Drupal\Core\Render\ElementInfoManager' => '\Drupal\Core\Render\Element\ElementInterface',
      '\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface',
      '\Drupal\Core\Field\FieldTypePluginManager' => '\Drupal\Core\Field\FieldItemInterface',
      '\Drupal\Core\Field\FormatterPluginManager' => '\Drupal\Core\Field\FormatterInterface',
      '\Drupal\Core\Field\WidgetPluginManager' => '\Drupal\Core\Field\WidgetInterface',
      '\Drupal\filter\FilterPluginManager' => '\Drupal\filter\Plugin\FilterInterface',
      '\Drupal\help\HelpSectionManager' => '\Drupal\help\HelpSectionPluginInterface',
      '\Drupal\image\ImageEffectManager' => '\Drupal\image\ImageEffectInterface',
      '\\Drupal\Core\Http\LinkRelationTypeManager' => '\Drupal\Core\Http\LinkRelationTypeInterface',
      '\Drupal\Core\Mail\MailManager' => '\Drupal\Core\Mail\MailInterface',
      '\Drupal\Core\Menu\ContextualLinkManager' => '\Drupal\Core\Menu\ContextualLinkInterface',
      '\Drupal\Core\Menu\LocalActionManager' => '\Drupal\Core\Menu\LocalActionInterface',
      '\Drupal\Core\Menu\LocalTaskManager' => '\Drupal\Core\Menu\LocalTaskInterface',
      '\Drupal\Core\Queue\QueueWorkerManager' => '\Drupal\Core\Queue\QueueWorkerInterface',
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
