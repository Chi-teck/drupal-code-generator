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
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => [
        'Module description',
        'TODO: Write description for the module'
      ],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => ['Dependencies (comma separated)', ''],
      'entity_label' => ['Entity label', [$this, 'defaultEntityLabel']],
      'entity_id' => ['Entity id', [$this, 'defaultEntityId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $vars['class_prefix'] = $this->human2class($vars['entity_label']);

    $templates = [
      'model.info.yml.twig',
      'src/Controller/ExampleListBuilder.php.twig',
      'src/Form/ExampleForm.php.twig',
      'src/Form/ExampleDeleteForm.php.twig',
      'src/ExampleInterface.php.twig',
      'src/Entity/Example.php.twig',
      'model.routing.yml.twig',
      'model.links.action.yml.twig',
      'config/schema/model.schema.yml.twig',
      'model.links.menu.yml.twig',
    ];

    $templates_path = 'd8/module/configuration-entity/';
    foreach ($templates as $template) {
      $path = $vars['machine_name'] . '/' . str_replace(['model', 'Example', '.twig'], [$vars['machine_name'], $vars['class_prefix'], ''], $template);
      $this->files[$path] = $this->render($templates_path . $template, $vars);
    }

  }

  /**
   * Returns default entity label.
   */
  protected function defaultEntityLabel($vars) {
    return $vars['name'];
  }

  /**
   * Returns default entity ID.
   */
  protected function defaultEntityId($vars) {
    return $this->human2machine($vars['entity_label']);
  }

}
