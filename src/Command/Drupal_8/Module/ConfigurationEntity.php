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
          return Utils::human2machine($vars['entity_type_label']);
        },
      ],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $vars['class_prefix'] = Utils::camelize($vars['entity_type_label']);

    $templates = [
      'model.info.yml.twig',
      'src/Controller/ExampleListBuilder.php.twig',
      'src/Form/ExampleForm.php.twig',
      'src/Form/ExampleDeleteForm.php.twig',
      'src/ExampleInterface.php.twig',
      'src/Entity/Example.php.twig',
      'model.routing.yml.twig',
      'model.links.action.yml.twig',
      'model.links.menu.yml.twig',
      'model.permissions.yml.twig',
      'config/schema/model.schema.yml.twig',
    ];

    $templates_path = 'd8/module/configuration-entity/';
    foreach ($templates as $template) {
      $search = ['model', 'Example', '.twig'];
      $replace = [$vars['machine_name'], $vars['class_prefix'], ''];
      $path = $vars['machine_name'] . '/' . str_replace($search, $replace, $template);
      $this->files[$path] = $this->render($templates_path . $template, $vars);
    }
  }

}
