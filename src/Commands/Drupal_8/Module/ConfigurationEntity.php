<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Module;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:module:configuration-entity command.
 */
class ConfigurationEntity extends BaseGenerator {

  protected $name = 'd8:module:configuration-entity';
  protected $description = 'Generates configuration entity module';
  protected $alias = 'configuration-entity';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => ['Dependencies (comma separated)', '', FALSE],
      'entity_type_label' => [
        'Entity type label', [$this, 'defaultEntityTypeLabel'],
      ],
      'entity_type_id' => ['Entity type id', [$this, 'defaultEntityTypeId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $vars['class_prefix'] = $this->human2class($vars['entity_type_label']);

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
      $path = $vars['machine_name'] . '/' . str_replace(
          ['model', 'Example', '.twig'],
          [$vars['machine_name'], $vars['class_prefix'], ''],
          $template
        );
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
    return $this->human2machine($vars['entity_type_label']);
  }

}
