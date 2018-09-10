<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:plugin-manager command.
 */
class PluginManager extends BaseGenerator {

  protected $name = 'd8:module:plugin-manager';
  protected $description = 'Generates plugin-manager module';
  protected $alias = 'plugin-manager';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['description'] = new Question('Description', 'Module description.');
    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');
    $default_plugin_type = function ($vars) {
      return $vars['machine_name'];
    };
    $questions['plugin_type'] = new Question('Plugin type', $default_plugin_type);
    // @todo Allow dots in plugin type.
    $questions['plugin_type']->setValidator([Utils::class, 'validateMachineName']);
    $discovery_types = [
      'annotation' => 'Annotation',
      'yaml' => 'YAML',
      'hook' => 'Hook',
    ];
    $choices = array_values($discovery_types);
    // Start choices list form '1'.
    array_unshift($choices, NULL);
    unset($choices[0]);
    $questions['discovery'] = new ChoiceQuestion('Discovery type', $choices, 'Annotation');

    $vars = &$this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }
    $vars['class_prefix'] = Utils::camelize($vars['plugin_type']);
    $vars['discovery'] = array_search($vars['discovery'], $discovery_types);

    $common_files = [
      'model.info.yml',
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

    $templates_path = 'd8/module/plugin-manager/' . $vars['discovery'] . '/';

    $path_placeholders = ['model', 'Example', 'examples'];
    $path_replacements = [
      $vars['machine_name'],
      $vars['class_prefix'],
      self::plural($vars['plugin_type']),
    ];

    foreach ($files as $file) {
      $this->addFile()
        ->path('{machine_name}/' . str_replace($path_placeholders, $path_replacements, $file))
        ->template($templates_path . $file . '.twig');
    }
  }

  /**
   * Pluralizes a noun.
   *
   * @todo Move this to Utils.
   */
  protected static function plural($string) {
    switch (substr($string, -1)) {
      case 'y':
        return substr($string, 0, -1) . 'ies';

      case 's':
        return $string . 'es';

      default:
        return $string . 's';
    }
  }

}
