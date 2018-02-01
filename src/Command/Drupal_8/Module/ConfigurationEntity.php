<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:configuration-entity command.
 */
class ConfigurationEntity extends BaseGenerator {

  protected $name = 'd8:module:configuration-entity';
  protected $description = 'Generates configuration entity module';
  protected $alias = 'configuration-entity';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');
    $questions['entity_type_label'] = new Question('Entity type label', '{name}');
    $questions['entity_type_id'] = new Question(
      'Entity type ID',
      function ($vars) {
        return Utils::human2machine($vars['entity_type_label']);
      }
    );

    $vars = &$this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }
    $vars['class_prefix'] = Utils::camelize($vars['entity_type_label']);

    $templates = [
      'model.info.yml.twig',
      'src/ExampleListBuilder.php.twig',
      'src/Form/ExampleForm.php.twig',
      'src/ExampleInterface.php.twig',
      'src/Entity/Example.php.twig',
      'model.routing.yml.twig',
      'model.links.action.yml.twig',
      'model.links.menu.yml.twig',
      'model.permissions.yml.twig',
      'config/schema/model.schema.yml.twig',
    ];

    $templates_path = 'd8/module/configuration-entity/';
    $path_placeholders = ['model', 'Example', '.twig'];
    $path_replacements = [$vars['machine_name'], $vars['class_prefix'], ''];
    foreach ($templates as $template) {
      $this->addFile()
        ->path('{machine_name}/' . str_replace($path_placeholders, $path_replacements, $template))
        ->template($templates_path . $template);
    }
  }

}
