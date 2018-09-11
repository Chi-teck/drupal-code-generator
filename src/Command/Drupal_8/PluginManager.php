<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin-manager command.
 */
class PluginManager extends BaseGenerator {

  protected $name = 'd8:plugin-manager';
  protected $description = 'Generates plugin manager';
  protected $alias = 'plugin-manager';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_plugin_type = function ($vars) {
      return $vars['machine_name'];
    };
    $questions['plugin_type'] = new Question('Plugin type', $default_plugin_type);

    // Utils::validateMachineName does not allow dots. But they can appear in
    // plugin types (field.widget, views.argument, etc).
    $questions['plugin_type']->setValidator(function ($value) {
      if (!preg_match('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct machine name.');
      }
      return $value;
    });

    $discovery_types = [
      'annotation' => 'Annotation',
      'yaml' => 'YAML',
      'hook' => 'Hook',
    ];
    $choices = Utils::prepareChoices($discovery_types);
    $questions['discovery'] = new ChoiceQuestion('Discovery type', $choices, 'Annotation');

    $vars = &$this->collectVars($input, $output, $questions);

    $vars['class_prefix'] = Utils::camelize($vars['plugin_type']);
    $vars['discovery'] = array_search($vars['discovery'], $discovery_types);

    $common_files = [
      'model.services.yml',
      'src/ExampleInterface.php',
      'src/ExamplePluginManager.php',
    ];

    $files = [];
    switch ($vars['discovery']) {
      case 'annotation':
        $files = [
          'src/Annotation/Example.php',
          'src/ExamplePluginBase.php',
          'src/Plugin/Example/Foo.php',
        ];
        break;

      case 'yaml':
        $files = [
          'model.examples.yml',
          'src/ExampleDefault.php',
        ];
        break;

      case 'hook':
        $files = [
          'model.module',
          'src/ExampleDefault.php',
        ];
        break;
    }

    $files = array_merge($common_files, $files);

    $templates_path = 'd8/plugin-manager/' . $vars['discovery'] . '/';

    $path_placeholders = ['model', 'Example', 'examples'];
    $path_replacements = [
      $vars['machine_name'],
      $vars['class_prefix'],
      Utils::pluralize($vars['plugin_type']),
    ];

    foreach ($files as $file) {
      $asset = $this->addFile()
        ->path(str_replace($path_placeholders, $path_replacements, $file))
        ->template($templates_path . $file . '.twig');
      if ($file === 'model.services.yml') {
        $asset->action('append')->headerSize(1);
      }
      elseif ($file == 'model.module') {
        $asset
          ->action('append')
          ->headerTemplate('d8/file-docs/module.twig')
          ->headerSize(7);
      }
    }
  }

}
