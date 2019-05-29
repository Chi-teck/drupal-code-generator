<?php

namespace DrupalCodeGenerator\Command\Module;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements module:content-entity command.
 */
class ContentEntity extends ModuleGenerator {

  protected $name = 'module:content-entity';
  protected $description = 'Generates content entity module';
  protected $alias = 'content-entity';
  protected $destination = 'modules';
  protected $isNewExtension = TRUE;
  protected $templatePath = Application::TEMPLATE_PATH . 'module/content-entity';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['dependencies'] = $this->ask('Dependencies (comma separated)');
    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['entity_base_path'] = $this->ask('Entity base path', '/admin/content/{entity_type_id|u2h}');
    $vars['fieldable'] = $this->confirm('Make the entity type fieldable?');
    $vars['revisionable'] = $this->confirm('Make the entity type revisionable?', FALSE);
    $vars['translatable'] = $this->confirm('Make the entity type translatable?', FALSE);
    $vars['bundle'] = $this->confirm('The entity type has bundle?', FALSE);
    $vars['template'] = $this->confirm('Create entity template?');
    $vars['access_controller'] = $this->confirm('Create CRUD permissions?', FALSE);
    $vars['title_base_field'] = $this->confirm('Add "title" base field?');
    $vars['status_base_field'] = $this->confirm('Add "status" base field?');
    $vars['created_base_field'] = $this->confirm('Add "created" base field?');
    $vars['changed_base_field'] = $this->confirm('Add "changed" base field?');
    $vars['author_base_field'] = $this->confirm('Add "author" base field?');
    $vars['description_base_field'] = $this->confirm('Add "description" base field?');
    $vars['rest_configuration'] = $this->confirm('Create REST configuration for the entity?', FALSE);

    $vars['dependencies'] = $vars['dependencies'] ?
      array_map('trim', explode(',', strtolower($vars['dependencies']))) : [];

    // 'text_long' field item plugin is provided by Text module.
    if ($vars['description_base_field']) {
      $vars['dependencies'][] = 'drupal:text';
    }

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

    $this->addFile('{machine_name}/{machine_name}.info.yml', 'model.info.yml');
    $this->addFile('{machine_name}/{machine_name}.links.action.yml', 'model.links.action.yml');
    $this->addFile('{machine_name}/{machine_name}.links.menu.yml', 'model.links.menu.yml');
    $this->addFile('{machine_name}/{machine_name}.links.task.yml', 'model.links.task.yml');
    $this->addFile('{machine_name}/{machine_name}.permissions.yml', 'model.permissions.yml');
    $this->addFile('{machine_name}/src/Entity/{class_prefix}.php', 'src/Entity/Example.php');
    $this->addFile('{machine_name}/src/{class_prefix}Interface.php', 'src/ExampleInterface.php');
    $this->addFile('{machine_name}/src/{class_prefix}ListBuilder.php', 'src/ExampleListBuilder.php');
    $this->addFile('{machine_name}/src/Form/{class_prefix}Form.php', 'src/Form/ExampleForm.php');

    if ($vars['fieldable_no_bundle']) {
      $this->addFile('{machine_name}/{machine_name}.routing.yml', 'model.routing.yml');
      $this->addFile('{machine_name}/src/Form/{class_prefix}SettingsForm.php', 'src/Form/ExampleSettingsForm.php');
    }

    if ($vars['template']) {
      $this->addFile('{machine_name}/templates/{entity_type_id|u2h}.html.twig', 'templates/model-example.html.twig');
      $this->addFile('{machine_name}/{machine_name}.module', 'model.module');
    }
    else {
      $this->addFile('{machine_name}/src/{class_prefix}ViewBuilder.php', 'src/ExampleViewBuilder.php');
    }

    if ($vars['access_controller']) {
      $this->addFile('{machine_name}/src/{class_prefix}AccessControlHandler.php', 'src/ExampleAccessControlHandler.php');
    }

    if ($vars['rest_configuration']) {
      $this->addFile('{machine_name}/config/optional/rest.resource.entity.{entity_type_id}', 'config/optional/rest.resource.entity.example.yml');
    }

    if ($vars['bundle']) {
      $this->addFile('{machine_name}/config/schema/{machine_name}.entity_type.schema.yml', 'config/schema/model.entity_type.schema.yml');
      $this->addFile('{machine_name}/src/{class_prefix}TypeListBuilder.php', 'src/ExampleTypeListBuilder.php');
      $this->addFile('{machine_name}/src/Entity/{class_prefix}Type.php', 'src/Entity/ExampleType.php');
      $this->addFile('{machine_name}/src/Form/{class_prefix}TypeForm.php', 'src/Form/ExampleTypeForm.php');
    }

  }

}
