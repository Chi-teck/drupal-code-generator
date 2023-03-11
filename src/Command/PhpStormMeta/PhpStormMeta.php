<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
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
    private readonly ContainerInterface $container,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self($container);
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpParamsInspection
   * @psalm-suppress ArgumentTypeCoercion
   */
  protected function generate(array &$vars, Assets $assets): void {
    /** @psalm-suppress NullableReturnStatement, InvalidNullableReturnType */
    $service = fn (string $name): object => $this->container->get($name);

    $entity_interface = static function (EntityTypeInterface $definition): ?string {
      $class = Utils::addLeadingSlash($definition->getClass());
      // Most content entity types implement an interface which name follows
      // this pattern.
      $interface = \str_replace('\Entity\\', '\\', $class) . 'Interface';
      return $definition->entityClassImplements($interface) ? $interface : NULL;
    };

    $assets[] = (new ConfigEntityIds($service('entity_type.manager'), $entity_interface))();
    $assets[] = (new Configuration($this->getHelper('config_info')))();
    $assets[] = (new Database($service('database')))();
    $assets[] = (new DateFormats($service('entity_type.manager')))();
    $assets[] = (new EntityBundles($service('entity_type.manager'), $service('entity_type.bundle.info'), $entity_interface))();
    $assets[] = (new EntityLinks($service('entity_type.manager'), $entity_interface))();
    $assets[] = (new EntityTypes($service('entity_type.manager')))();
    $assets[] = (new Extensions($service('module_handler'), $service('theme_handler')))();
    $assets[] = (new FieldDefinitions($service('entity_type.manager'), $service('plugin.manager.field.field_type')))();
    $assets[] = (new Fields($service('entity_type.manager'), $service('entity_field.manager'), $entity_interface))();
    $assets[] = (new FileSystem())();
    $assets[] = (new Miscellaneous())();
    $assets[] = (new Permissions($this->getHelper('permission_info')))();
    $assets[] = (new Plugins($this->getHelper('service_info')))();
    $assets[] = (new Roles($service('entity_type.manager')))();
    $assets[] = (new Routes($this->getHelper('route_info')))();
    $assets[] = (new Services($this->getHelper('service_info')))();
    $assets[] = (new Settings())();
    $assets[] = (new States($service('keyvalue')))();
  }

  /**
   * {@inheritdoc}
   */
  protected function getDestination(array $vars): string {
    // Typically the root of the PhpStorm project is one level above of the
    // Drupal root.
    if (!\file_exists(\DRUPAL_ROOT . '/.idea') && \file_exists(\DRUPAL_ROOT . '/../.idea')) {
      return \DRUPAL_ROOT . '/..';
    }
    return \DRUPAL_ROOT;
  }

}
