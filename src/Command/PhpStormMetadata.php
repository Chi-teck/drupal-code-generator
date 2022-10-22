<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'phpstorm-metadata',
  description: 'Generates PhpStorm metadata',
  templatePath: Application::TEMPLATE_PATH . '/phpstorm-metadata',
  type: GeneratorType::OTHER,
  label: 'PhpStorm metadata',
)]
final class PhpStormMetadata extends BaseGenerator implements ContainerInjectionInterface {

  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFieldManagerInterface $entityFieldManager,
  ) {
    parent::__construct();
  }

  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
    );
  }

  protected function generate(array &$vars, AssetCollection $assets): void {

    $service_info = $this->getHelper('service_info');
    $service_definitions = $service_info->getServiceDefinitions();

    foreach ($service_definitions as $service_id => $service_definition) {
      if ($service_definition['class'] ?? NULL) {
        $vars['services'][$service_id] = $service_definition['class'];
      }
    }
    \ksort($vars['services']);

    $vars['plugins'] = self::getPlugins();

    $vars['storages'] = [];
    $vars['view_builders'] = [];
    $vars['list_builders'] = [];
    $vars['access_controls'] = [];
    $vars['entity_classes'] = [];
    foreach ($this->entityTypeManager->getDefinitions() as $type => $definition) {
      $vars['entity_classes'][] = $definition->getClass();
      $vars['storages'][$type] = $definition->getStorageClass();
      $vars['access_controls'][$type] = $definition->getAccessControlClass();
      if ($definition->hasViewBuilderClass()) {
        $vars['view_builders'][$type] = $definition->getViewBuilderClass();
      }
      if ($definition->hasListBuilderClass()) {
        $vars['list_builders'][$type] = $definition->getListBuilderClass();
      }
    }
    // Some classes do not have leading slash.
    \array_walk_recursive($vars, static function (string &$class): void {
      if (!\str_starts_with($class, '\\')) {
        $class = '\\' . $class;
      }
    });

    $sort = static function (array &$items): void {
      \ksort($items);
    };
    \array_walk($vars, $sort);

    $vars['route_names'] = $this->getHelper('route_info')->getRouteNames();
    $vars['config_names'] = $this->getHelper('config_info')->getConfigNames();

    $vars['entity_fields'] = $this->getEntityFields();
    $vars['role_names'] = $this->getRoleNames();

    $vars['permission_names'] = $this->getHelper('permission_info')->getPermissionNames();

    $assets->addFile('.phpstorm.meta.php', 'phpstorm.meta.php.twig');
  }

  /**
   * Gets role names.
   */
  public function getRoleNames(): array {
    $roles = $this->entityTypeManager->getStorage('user_role')->loadMultiple();
    return \array_keys($roles);
  }

  /**
   * Gets entity fields.
   */
  private function getEntityFields(): array {
    $entity_fields = [];
    foreach ($this->entityTypeManager->getDefinitions() as $entity_type => $definition) {
      if (!$definition->entityClassImplements(FieldableEntityInterface::class)) {
        continue;
      }
      $class = '\\' . \ltrim($definition->getClass(), '\\');
      // Most of content entity types implement an interface which name matches
      // the following pattern.
      $interface = \str_replace('\Entity\\', '\\', $class) . 'Interface';
      $entity_fields[] = [
        'type' => $entity_type,
        'class' => $class,
        'interface' => $definition->entityClassImplements($interface) ? $interface : NULL,
        'fields' => \array_keys($this->entityFieldManager->getFieldStorageDefinitions($entity_type)),
      ];
    }
    return $entity_fields;
  }

  /**
   * Returns plugin interfaces.
   *
   * It's tricky to get the interfaces automatically as the
   * PluginManagerBase::getFactory() method is protected. Here is a code snippet
   * to obtain classes of plugin managers. The supported plugin interface needs
   * to be checked manually for each plugin manager.
   * @code
   *   $plugin_managers = \array_filter(
   *     $vars['services'],
   *     static fn (string $class): bool => \is_subclass_of($class, PluginManagerInterface::class),
   *   );
   * @endcode
   */
  private static function getPlugins(): array {
    // The \Drupal\views\Plugin\ViewsPluginManager class is not listed here as
    // it is used by multiple plugin mangers.
    return [
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
  }

}
