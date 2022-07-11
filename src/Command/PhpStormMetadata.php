<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

// @todo Clean-up.
#[Generator(
  name: 'phpstorm-metadata',
  description: 'Generates PhpStorm metadata',
  templatePath: Application::TEMPLATE_PATH . '/phpstorm-metadata',
  type: GeneratorType::OTHER,
  label: 'PhpStorm metadata',
)]
final class PhpStormMetadata extends BaseGenerator implements ContainerInjectionInterface {

  public function __construct(private readonly EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct();
  }

  public static function create(ContainerInterface $container): self {
    return new self($container->get('entity_type.manager'));
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
      if ($class[0] != '\\') {
        $class = '\\' . $class;
      }
    });

    $sort = static function (array &$items): void {
      \ksort($items);
    };
    \array_walk($vars, $sort);

    $assets->addFile('.phpstorm.meta.php', 'phpstorm.meta.php.twig');
  }

}
