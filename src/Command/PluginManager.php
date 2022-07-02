<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'plugin-manager',
  description: 'Generates plugin manager',
  templatePath: Application::TEMPLATE_PATH . '/plugin-manager',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class PluginManager extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    // Machine name validator does not allow dots.
    $plugin_type_validator = static function (string $value): string {
      if (!\preg_match('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct machine name.');
      }
      return $value;
    };
    $vars['plugin_type'] = $ir->ask('Plugin type', '{machine_name}', new Chained(new Required(), $plugin_type_validator));

    $discovery_types = [
      'annotation' => 'Annotation',
      'yaml' => 'YAML',
      'hook' => 'Hook',
    ];
    $vars['discovery'] = $ir->choice('Discovery type', $discovery_types, 'Annotation');
    $vars['class_prefix'] = '{plugin_type|camelize}';

    $assets->addServicesFile()->template('{discovery}/model.services.yml');
    $assets->addFile('src/{class_prefix}Interface.php', '{discovery}/src/ExampleInterface.php');
    $assets->addFile('src/{class_prefix}PluginManager.php', '{discovery}/src/ExamplePluginManager.php');

    switch ($vars['discovery']) {
      case 'annotation':
        $assets->addFile('src/Annotation/{class_prefix}.php', 'annotation/src/Annotation/Example.php');
        $assets->addFile('src/{class_prefix}PluginBase.php', 'annotation/src/ExamplePluginBase.php');
        $assets->addFile('src/Plugin/{class_prefix}/Foo.php', 'annotation/src/Plugin/Example/Foo.php');
        break;

      case 'yaml':
        $assets->addFile('{machine_name}.{plugin_type|pluralize}.yml', 'yaml/model.examples.yml');
        $assets->addFile('src/{class_prefix}Default.php', 'yaml/src/ExampleDefault.php');
        break;

      case 'hook':
        $assets->addFile('{machine_name}.module', 'hook/model.module')->appendIfExists(7);
        $assets->addFile('src/{class_prefix}Default.php', 'hook/src/ExampleDefault.php');
        break;
    }

  }

}
