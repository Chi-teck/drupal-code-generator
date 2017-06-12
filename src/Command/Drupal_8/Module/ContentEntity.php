<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:content-entity command.
 */
class ContentEntity extends BaseGenerator {

  protected $name = 'd8:module:content-entity';
  protected $description = 'Generates content entity module';
  protected $alias = 'content-entity';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => new Question('Dependencies (comma separated)', ''),
      'entity_type_label' => [
        'Entity type label',
        function ($vars) {
          return $vars['name'];
        },
      ],
      'entity_type_id' => [
        'Entity type id',
        function ($vars) {
          $entity_type_id = Utils::human2machine($vars['entity_type_label']);
          if ($entity_type_id != $vars['machine_name']) {
            $entity_type_id = $vars['machine_name'] . '_' . $entity_type_id;
          }
          return $entity_type_id;
        },
      ],
      'entity_base_path' => [
        'Entity base path',
        function ($vars) {
          return '/admin/content/' . str_replace('_', '-', $vars['entity_type_id']);
        },
      ],
      'fieldable' => ['Make the entity type fieldable?', 'yes'],
      'revisionable' => ['Make the entity type revisionable?', 'no'],
      'template' => ['Create entity template?', 'yes'],
      'access_controller' => ['Create CRUD permissions?', 'no'],
      'title_base_field' => ['Add "title" base field?', 'yes'],
      'status_base_field' => ['Add "status" base field?', 'yes'],
      'created_base_field' => ['Add "created" base field?', 'yes'],
      'changed_base_field' => ['Add "changed" base field?', 'yes'],
      'author_base_field' => ['Add "author" base field?', 'yes'],
      'description_base_field' => ['Add "description" base field?', 'yes'],
      'rest_configuration' => ['Create REST configuration for the entity?',
        'no',
      ],
    ];

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

    $vars['class_prefix'] = Utils::camelize($vars['entity_type_label']);

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

}
