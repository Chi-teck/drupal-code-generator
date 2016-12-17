<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Module;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:module:content-entity command.
 */
class ContentEntity extends BaseGenerator {

  protected $name = 'd8:module:content-entity';
  protected $description = 'Generates content entity module';
  protected $alias = 'content-entity';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = $this->defaultQuestions();
    $questions['name'] = ['Module name'];
    $questions['machine_name'] = ['Module machine name'];
    $questions['package'] = ['Package', 'custom'];
    $questions['version'] = ['Version', '8.x-1.0-dev'];
    $questions['dependencies'] = ['Dependencies (comma separated)', '', FALSE];
    $questions['entity_type_label'] = [
      'Entity type label', [$this, 'defaultEntityTypeLabel'],
    ];
    $questions['entity_type_id'] = [
      'Entity type id', [$this, 'defaultEntityTypeId'],
    ];
    $questions['entity_base_path'] = [
      'Entity base path', [$this, 'defaultEntityBasePath'],
    ];
    $questions['fieldable'] = ['Make the entity type fieldable?', 'yes'];
    $questions['revisionable'] = ['Make the entity type revisionable?', 'no'];
    $questions['template'] = ['Create entity template?', 'yes'];
    $questions['access_controller'] = ['Create CRUD permissions?', 'no'];
    $questions['title_base_field'] = ['Add "title" base field?', 'yes'];
    $questions['status_base_field'] = ['Add "status" base field?', 'yes'];
    $questions['created_base_field'] = ['Add "created" base field?', 'yes'];
    $questions['changed_base_field'] = ['Add "changed" base field?', 'yes'];
    $questions['author_base_field'] = ['Add "author" base field?', 'yes'];
    $questions['description_base_field'] = ['Add "description" base field?', 'yes'];
    $questions['rest_configuration'] = ['Create REST configuration for the entity?', 'no'];

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    if ($vars['entity_base_path'][0] != '/') {
      $vars['entity_base_path'] = '/' . $vars['entity_base_path'];
    }

    if ($vars['fieldable']) {
      $vars['configure'] = 'entity.' . $vars['entity_type_id'] . '.collection';
    }

    $vars['class_prefix'] = $this->human2class($vars['entity_type_label']);

    $templates = [
      'model.info.yml.twig',
      'model.links.action.yml.twig',
      'model.links.menu.yml.twig',
      'model.links.task.yml.twig',
      'model.permissions.yml.twig',
      'model.routing.yml.twig',
      'src/Entity/Example.php.twig',
      'src/ExampleInterface.php.twig',
      'src/ExampleListBuilder.php.twig',
      'src/Form/ExampleForm.php.twig',
      'src/Form/ExampleSettingsForm.php.twig',
    ];

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
    ];

    foreach ($templates as $template) {
      $path = $vars['machine_name'] . '/' . str_replace($path_placeholders, $path_replacements, $template);
      $path = preg_replace('#\.twig$#', '', $path);
      $this->files[$path] = $this->render($templates_path . $template, $vars);
    }
  }

  /**
   * Returns default entity label.
   */
  protected function defaultEntityTypeLabel($vars) {
    return $vars['name'];
  }

  /**
   * Returns default entity ID.
   */
  protected function defaultEntityTypeId($vars) {
    $entity_type_id = $this->human2machine($vars['entity_type_label']);
    if ($entity_type_id != $vars['machine_name']) {
      $entity_type_id = $vars['machine_name'] . '_' . $entity_type_id;
    }
    return $entity_type_id;
  }

  /**
   * Returns default entity base path.
   */
  protected function defaultEntityBasePath($vars) {
    return '/admin/content/' . str_replace('_', '-', $vars['entity_type_id']);
  }

}
