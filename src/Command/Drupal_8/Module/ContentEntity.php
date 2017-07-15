<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
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
    $questions = Utils::defaultQuestions();

    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');
    $questions['entity_type_label'] = new Question(
      'Entity type label',
      function ($vars) {
        return $vars['name'];
      }
    );
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

    $questions['fieldable'] = new ConfirmationQuestion('Make the entity type fieldable?', TRUE);
    $questions['revisionable'] = new ConfirmationQuestion('Make the entity type revisionable?', FALSE);
    $questions['template'] = new ConfirmationQuestion('Create entity template?', TRUE);
    $questions['access_controller'] = new ConfirmationQuestion('Create CRUD permissions?', FALSE);
    $questions['title_base_field'] = new ConfirmationQuestion('Add "title" base field?', TRUE);
    $questions['status_base_field'] = new ConfirmationQuestion('Add "status" base field?', TRUE);
    $questions['created_base_field'] = new ConfirmationQuestion('Add "created" base field?', TRUE);
    $questions['changed_base_field'] = new ConfirmationQuestion('Add "changed" base field?', TRUE);
    $questions['author_base_field'] = new ConfirmationQuestion('Add "author" base field?', TRUE);
    $questions['description_base_field'] = new ConfirmationQuestion('Add "description" base field?', TRUE);
    $questions['rest_configuration'] = new ConfirmationQuestion('Create REST configuration for the entity?', FALSE);

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }

    if ($vars['entity_base_path'][0] != '/') {
      $vars['entity_base_path'] = '/' . $vars['entity_base_path'];
    }

    if ($vars['fieldable']) {
      $vars['configure'] = 'entity.' . $vars['entity_type_id'] . '.settings';
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
    ];

    if ($vars['fieldable']) {
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
      $this->setFile($path, $templates_path . $template, $vars);
    }
  }

}
