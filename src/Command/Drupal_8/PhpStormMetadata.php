<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:phpstorm-metadata command.
 */
class PhpStormMetadata extends BaseGenerator {

  protected $name = 'd8:phpstorm-metadata';
  protected $description = 'Generates PhpStorm metadata';
  protected $label = 'PhpStorm metadata';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    if (!class_exists('Drupal') || !\Drupal::hasContainer()) {
      throw new \RuntimeException('Could not bootstrap Drupal to fetch metadata.');
    }
    $container = \Drupal::getContainer();

    $vars = &$this->vars;

    $service_definitions = $container
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

    $this->addFile()
      ->path('.phpstorm.meta.php')
      ->template('d8/phpstorm-meta.twig');
  }

}
