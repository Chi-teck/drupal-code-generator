<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:content-entity command.
 */
class ContentEntity extends ModuleGenerator {

  protected $name = 'd8:module:content-entity';
  protected $description = 'Generates content entity module';
  protected $alias = 'content-entity';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');
    $questions['entity_type_label'] = new Question('Entity type label', '{name}');
    $questions['entity_type_id'] = new Question(
      'Entity type ID',
      function ($vars) {
        return Utils::human2machine($vars['entity_type_label']);
      }
    );
    $questions['entity_base_path'] = new Question(
      'Entity base path',
      function ($vars) {
        return '/admin/content/' . str_replace('_', '-', $vars['entity_type_id']);
      }
    );
    $this->collectVars($questions);

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

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }
    else {
      $vars['dependencies'] = [];
    }
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

    $templates = [
      'model.info.yml.twig',
      'model.links.action.yml.twig',
      'model.links.menu.yml.twig',
      'model.links.task.yml.twig',
      'model.permissions.yml.twig',
      'src/Entity/Example.php.twig',
      'src/ExampleInterface.php.twig',
      'src/ExampleListBuilder.php.twig',
      'src/Form/ExampleForm.php.twig',
    ];

    if ($vars['fieldable_no_bundle']) {
      $templates[] = 'model.routing.yml.twig';
      $templates[] = 'src/Form/ExampleSettingsForm.php.twig';
    }

    if ($vars['template']) {
      $templates[] = 'templates/model-example.html.twig.twig';
      $templates[] = 'model.module.twig';
    }
    else {
      $templates[] = 'src/ExampleViewBuilder.php.twig';
    }

    if ($vars['access_controller']) {
      $templates[] = 'src/ExampleAccessControlHandler.php.twig';
    }

    if ($vars['rest_configuration']) {
      $templates[] = 'config/optional/rest.resource.entity.example.yml.twig';
    }

    if ($vars['bundle']) {
      $templates[] = 'config/schema/model.entity_type.schema.yml.twig';
      $templates[] = 'src/ExampleTypeListBuilder.php.twig';
      $templates[] = 'src/Entity/ExampleType.php.twig';
      $templates[] = 'src/Form/ExampleTypeForm.php.twig';
    }

    $templates_path = 'd8/module/content-entity/';

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
      'views.view.' . $vars['entity_type_id'],
    ];

    foreach ($templates as $template) {
      $path = $vars['machine_name'] . '/' . str_replace($path_placeholders, $path_replacements, $template);
      $this->addFile()
        ->path(preg_replace('#\.twig$#', '', $path))
        ->template($templates_path . $template);
    }
  }

}
