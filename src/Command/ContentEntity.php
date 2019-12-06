<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\File;

/**
 * Implements content-entity command.
 */
final class ContentEntity extends ModuleGenerator {

  protected $name = 'content-entity';
  protected $description = 'Generates content entity module';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();

    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['entity_base_path'] = $this->ask('Entity base path', '/admin/content/{entity_type_id|u2h}');
    $vars['fieldable'] = $this->confirm('Make the entity type fieldable?');
    $vars['revisionable'] = $this->confirm('Make the entity type revisionable?', FALSE);
    $vars['translatable'] = $this->confirm('Make the entity type translatable?', FALSE);
    $vars['bundle'] = $this->confirm('The entity type has bundle?', FALSE);
    $vars['template'] = $this->confirm('Create entity template?');
    $vars['access_controller'] = $this->confirm('Create CRUD permissions?', FALSE);

    $vars['label_base_field'] = $this->confirm('Add "label" base field?');
    $vars['status_base_field'] = $this->confirm('Add "status" base field?');
    $vars['created_base_field'] = $this->confirm('Add "created" base field?');
    $vars['changed_base_field'] = $this->confirm('Add "changed" base field?');
    $vars['author_base_field'] = $this->confirm('Add "author" base field?');
    $vars['description_base_field'] = $this->confirm('Add "description" base field?');
    $vars['has_base_fields'] = $vars['label_base_field'] || $vars['status_base_field'] ||
                               $vars['created_base_field'] || $vars['changed_base_field'] ||
                               $vars['author_base_field'] || $vars['description_base_field'];

    $vars['rest_configuration'] = $this->confirm('Create REST configuration for the entity?', FALSE);

    if ($vars['entity_base_path'][0] != '/') {
      $vars['entity_base_path'] = '/{entity_base_path}';
    }

    if (($vars['fieldable_no_bundle'] = $vars['fieldable'] && !$vars['bundle'])) {
      $vars['configure'] = 'entity.{entity_type_id}.settings';
    }
    elseif ($vars['bundle']) {
      $vars['configure'] = 'entity.{entity_type_id}_type.collection';
    }

    $vars['class_prefix'] = '{entity_type_id|camelize}';
    $vars['template_name'] = '{entity_type_id|u2h}.html.twig';

    $this->addFile('{machine_name}.links.action.yml', 'model.links.action.yml')
      ->action(File::ACTION_APPEND);
    $this->addFile('{machine_name}.links.menu.yml', 'model.links.menu.yml')
      ->action(File::ACTION_APPEND);
    $this->addFile('{machine_name}.links.task.yml', 'model.links.task.yml')
      ->action(File::ACTION_APPEND);
    $this->addFile('{machine_name}.permissions.yml', 'model.permissions.yml')
      ->action(File::ACTION_APPEND);
    $this->addFile('src/Entity/{class_prefix}.php', 'src/Entity/Example.php');
    $this->addFile('src/{class_prefix}Interface.php', 'src/ExampleInterface.php');
    $this->addFile('src/{class_prefix}ListBuilder.php', 'src/ExampleListBuilder.php');
    $this->addFile('src/Form/{class_prefix}Form.php', 'src/Form/ExampleForm.php');

    if ($vars['fieldable_no_bundle']) {
      $this->addFile('{machine_name}.routing.yml', 'model.routing.yml')
        ->action(File::ACTION_APPEND);
      $this->addFile('src/Form/{class_prefix}SettingsForm.php', 'src/Form/ExampleSettingsForm.php');
    }

    if ($vars['template']) {
      $this->addFile('templates/{entity_type_id|u2h}.html.twig', 'templates/model-example.html.twig');
      $this->addFile('{machine_name}.module', 'model.module')
        ->action(File::ACTION_APPEND)
        ->headerSize(7);
    }
    else {
      $this->addFile('src/{class_prefix}ViewBuilder.php', 'src/ExampleViewBuilder.php');
    }

    if ($vars['access_controller']) {
      $this->addFile('src/{class_prefix}AccessControlHandler.php', 'src/ExampleAccessControlHandler.php');
    }

    if ($vars['rest_configuration']) {
      $this->addFile('config/optional/rest.resource.entity.{entity_type_id}', 'config/optional/rest.resource.entity.example.yml');
    }

    if ($vars['bundle']) {
      $this->addFile('config/schema/{machine_name}.entity_type.schema.yml', 'config/schema/model.entity_type.schema.yml')
        ->action(File::ACTION_APPEND);
      $this->addFile('src/{class_prefix}TypeListBuilder.php', 'src/ExampleTypeListBuilder.php');
      $this->addFile('src/Entity/{class_prefix}Type.php', 'src/Entity/ExampleType.php');
      $this->addFile('src/Form/{class_prefix}TypeForm.php', 'src/Form/ExampleTypeForm.php');
    }

  }

}
