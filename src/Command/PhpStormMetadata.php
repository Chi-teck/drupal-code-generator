<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Helper\DrupalContext;

/**
 * Implements phpstorm-metadata command.
 */
final class PhpStormMetadata extends DrupalGenerator {

  protected $name = 'phpstorm-metadata';
  protected $description = 'Generates PhpStorm metadata';
  protected $label = 'PhpStorm metadata';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {

    if (!$this->drupalContext) {
      $this->io()->error('Could not bootstrap Drupal to fetch metadata.');
      return;
    }

    $container = $this->drupalContext->getContainer();

    $vars = &$this->vars;

    $service_definitions = $this->drupalContext
      ->getContainer()
      ->get('kernel')
      ->getCachedContainerDefinition()['services'];
    $service_definitions = array_map('unserialize', $service_definitions);

    foreach ($service_definitions as $service_id => $service_definition) {
      if ($service_definition['class']) {
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
      /** @var \Drupal\Core\Entity\EntityTypeInterface $definition  */
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
    array_walk_recursive($vars, function (string &$class): void {
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
