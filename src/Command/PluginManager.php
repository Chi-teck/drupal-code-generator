<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\RegExp;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'plugin-manager',
  description: 'Generates plugin manager',
  aliases: ['plugin-manager'],
  templatePath: Application::TEMPLATE_PATH . '/_plugin-manager',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class PluginManager extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    // Machine name validator does not allow dots.
    $validator = new Chained(
      new Required(),
      new RegExp('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', 'The value is not correct machine name.'),
    );
    $vars['plugin_type'] = $ir->ask('Plugin type', '{machine_name}', $validator);

    $discovery_types = [
      'annotation' => 'Annotation',
      'attribute' => 'Attribute',
      'yaml' => 'YAML',
      'hook' => 'Hook',
    ];
    $vars['discovery'] = $ir->choice('Discovery type', $discovery_types, 'Annotation');
    $vars['class_prefix'] = '{plugin_type|camelize}';

    $assets->addServicesFile()->template('{discovery}/model.services.yml.twig');
    $assets->addFile('src/{class_prefix}Interface.php', '{discovery}/src/ExampleInterface.php.twig');
    $assets->addFile('src/{class_prefix}PluginManager.php', '{discovery}/src/ExamplePluginManager.php.twig');

    switch ($vars['discovery']) {
      case 'annotation':
        $assets->addFile('src/Annotation/{class_prefix}.php', 'annotation/src/Annotation/Example.php.twig');
        $assets->addFile('src/{class_prefix}PluginBase.php', 'annotation/src/ExamplePluginBase.php.twig');
        $assets->addFile('src/Plugin/{class_prefix}/Foo.php', 'annotation/src/Plugin/Example/Foo.php.twig');
        break;

      case 'attribute':
        $assets->addFile('src/Attribute/{class_prefix}.php', 'attribute/src/Attribute/Example.php.twig');
        $assets->addFile('src/{class_prefix}PluginBase.php', 'attribute/src/ExamplePluginBase.php.twig');
        $assets->addFile('src/Plugin/{class_prefix}/Foo.php', 'attribute/src/Plugin/Example/Foo.php.twig');
        break;

      case 'yaml':
        $assets->addFile('{machine_name}.{plugin_type|pluralize}.yml', 'yaml/model.examples.yml.twig');
        $assets->addFile('src/{class_prefix}Default.php', 'yaml/src/ExampleDefault.php.twig');
        break;

      case 'hook':
        $assets->addFile('{machine_name}.module', 'hook/model.module.twig')->appendIfExists(7);
        $assets->addFile('src/{class_prefix}Default.php', 'hook/src/ExampleDefault.php.twig');
        break;
    }

  }

}
