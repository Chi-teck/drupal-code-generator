<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements configuration-entity command.
 */
class ConfigurationEntity extends ModuleGenerator {

  protected $name = 'configuration-entity';
  protected $description = 'Generates configuration entity module';
  protected $alias = 'configuration-entity';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['class_prefix'] = '{entity_type_id|camelize}';

    $files = [
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
      $this->addFile(str_replace($path_placeholders, $path_replacements, $file))
        ->template('_configuration-entity/' . $file);
    }

    // Add 'configure' link to the info file if it exists.
    $update_info = function (?string $existing_content) use ($vars) {
      if ($existing_content && !preg_match('/^configure: /m', $existing_content)) {
        return "{$existing_content}configure: entity.{$vars['entity_type_id']}.collection\n";
      }
    };
    $this->addFile('{machine_name}.info.yml')
      ->action($update_info);
  }

}
