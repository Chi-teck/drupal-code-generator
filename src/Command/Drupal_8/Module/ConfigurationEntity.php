<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:module:configuration-entity command.
 */
class ConfigurationEntity extends ModuleGenerator {

  protected $name = 'd8:module:configuration-entity';
  protected $description = 'Generates configuration entity module';
  protected $alias = 'configuration-entity';
  protected $destination = 'modules';
  protected $isNewExtension = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['dependencies'] = $this->ask('Dependencies (comma separated)');
    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }
    $vars['class_prefix'] = Utils::camelize($vars['entity_type_id']);

    $files = [
      'model.info.yml',
      'src/ExampleListBuilder.php',
      'src/Form/ExampleForm.php',
      'src/ExampleInterface.php',
      'src/Entity/Example.php',
      'model.routing.yml',
      'model.links.action.yml',
      'model.links.menu.yml',
      'model.permissions.yml',
      'config/schema/model.schema.yml',
    ];

    $path_placeholders = ['model', 'Example'];
    $path_replacements = [$vars['machine_name'], $vars['class_prefix']];
    foreach ($files as $file) {
      $this->addFile('{machine_name}/' . str_replace($path_placeholders, $path_replacements, $file))
        ->template('d8/module/configuration-entity/' . $file);
    }
  }

}
