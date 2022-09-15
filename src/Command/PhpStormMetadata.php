<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Exception\RuntimeException;
use DrupalCodeGenerator\Helper\DrupalContext;

/**
 * Implements phpstorm-metadata command.
 */
final class PhpStormMetadata extends DrupalGenerator {

  protected string $name = 'phpstorm-metadata';
  protected string $description = 'Generates PhpStorm metadata';
  protected string $label = 'PhpStorm metadata';
  protected string $templatePath = Application::TEMPLATE_PATH . '/phpstorm-metadata';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {

    if (!$this->drupalContext) {
      throw new RuntimeException('Could not bootstrap Drupal to fetch metadata.');
    }

    $container = $this->drupalContext->getContainer();

    $service_definitions = $this->drupalContext
      ->getContainer()
      ->get('kernel')
      ->getCachedContainerDefinition()['services'];
    $service_definitions = \array_map('unserialize', $service_definitions);

    foreach ($service_definitions as $service_id => $service_definition) {
      if ($service_definition['class'] ?? NULL) {
        $vars['services'][$service_id] = $service_definition['class'];
      }
    }

    $entity_type_manager = $container->get('entity_type.manager');
    $vars['storages'] = [];
    $vars['view_builders'] = [];
    $vars['list_builders'] = [];
    $vars['access_controls'] = [];
    $vars['entity_classes'] = [];
    foreach ($entity_type_manager->getDefinitions() as $type => $definition) {
      /** @var \Drupal\Core\Entity\EntityTypeInterface $definition */
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

    // Some classes does not have leading slash.
    \array_walk_recursive($vars, static function (string &$class): void {
      if ($class[0] != '\\') {
        $class = '\\' . $class;
      }
    });

    $this->addFile('.phpstorm.meta.php', 'phpstorm.meta.php');
  }

  /**
   * Setter for Drupal context (for testing).
   */
  public function setDrupalContext(DrupalContext $drupal_context): void {
    $this->drupalContext = $drupal_context;
  }

}
