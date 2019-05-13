<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:module:content-entity command.
 */
class ContentEntity extends ModuleGenerator {

  protected $name = 'd8:module:content-entity';
  protected $description = 'Generates content entity module';
  protected $alias = 'content-entity';
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
      $vars['entity_base_path'] = '/' . $vars['entity_base_path'];
    }

    if (($vars['fieldable_no_bundle'] = $vars['fieldable'] && !$vars['bundle'])) {
      $vars['configure'] = 'entity.' . $vars['entity_type_id'] . '.settings';
    }
    elseif ($vars['bundle']) {
      $vars['configure'] = 'entity.' . $vars['entity_type_id'] . '_type.collection';
    }

    $vars['class_prefix'] = Utils::camelize($vars['entity_type_id']);

    $files = [
      'model.info.yml',
      'model.links.action.yml',
      'model.links.menu.yml',
      'model.links.task.yml',
      'model.permissions.yml',
      'src/Entity/Example.php',
      'src/ExampleInterface.php',
      'src/ExampleListBuilder.php',
      'src/Form/ExampleForm.php',
    ];

    if ($vars['fieldable_no_bundle']) {
      $files[] = 'model.routing.yml';
      $files[] = 'src/Form/ExampleSettingsForm.php';
    }

    if ($vars['template']) {
      $files[] = 'templates/model-example.html.twig';
      $files[] = 'model.module';
    }
    else {
      $files[] = 'src/ExampleViewBuilder.php';
    }

    if ($vars['access_controller']) {
      $files[] = 'src/ExampleAccessControlHandler.php';
    }

    if ($vars['rest_configuration']) {
      $files[] = 'config/optional/rest.resource.entity.example.yml';
    }

    if ($vars['bundle']) {
      $files[] = 'config/schema/model.entity_type.schema.yml';
      $files[] = 'src/ExampleTypeListBuilder.php';
      $files[] = 'src/Entity/ExampleType.php';
      $files[] = 'src/Form/ExampleTypeForm.php';
    }

    $vars['template_name'] = str_replace('_', '-', $vars['entity_type_id']) . '.html.twig';

    $path_placeholders = [
      'model-example.html.twig',
      'model',
      'Example',
      'rest.resource.entity.example',
    ];
    $path_replacements = [
      $vars['template_name'],
      $vars['machine_name'],
      $vars['class_prefix'],
      'rest.resource.entity.' . $vars['entity_type_id'],
    ];

    foreach ($files as $file) {
      $path = $vars['machine_name'] . '/' . str_replace($path_placeholders, $path_replacements, $file);
      $template = 'd8/module/content-entity/' . $file;
      if ($file == 'templates/model-example.html.twig') {
        $template .= '.twig';
      }
      $this->addFile($path, $template);
    }
  }

}
