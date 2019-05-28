<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset;

/**
 * Implements configuration-entity command.
 */
class ConfigurationEntity extends ModuleGenerator {

  protected $name = 'configuration-entity';
  protected $description = 'Generates configuration entity module';
  protected $alias = 'config-entity';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['class_prefix'] = '{entity_type_id|camelize}';

    $this->addFile('src/{class_prefix}ListBuilder.php', '_configuration-entity/src/ExampleListBuilder.php');
    $this->addFile('src/Form/{class_prefix}Form.php', '_configuration-entity/src/Form/ExampleForm.php');
    $this->addFile('src/{class_prefix}Interface.php', '_configuration-entity/src/ExampleInterface.php');
    $this->addFile('src/Entity/{class_prefix}.php', '_configuration-entity/src/Entity/Example.php');
    $this->addFile('{machine_name}.routing.yml', '_configuration-entity/model.routing.yml')
      ->action(Asset::APPEND);
    $this->addFile('{machine_name}.links.action.yml', '_configuration-entity/model.links.action.yml')
      ->action(Asset::APPEND);
    $this->addFile('{machine_name}.links.menu.yml', '_configuration-entity/model.links.menu.yml')
      ->action(Asset::APPEND);
    $this->addFile('{machine_name}.permissions.yml', '_configuration-entity/model.permissions.yml')
      ->action(Asset::APPEND);
    $this->addFile('config/schema/{machine_name}.schema.yml', '_configuration-entity/config/schema/model.schema.yml')
      ->action(Asset::APPEND);

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
