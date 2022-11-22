<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\RegExp;
use DrupalCodeGenerator\Validator\Required;

/**
 * Constraint generator.
 *
 * @todo Clean-up.
 * @todo Create SUT test.
 */
#[Generator(
  name: 'plugin:constraint',
  description: 'Generates constraint plugin',
  aliases: ['constraint'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_constraint',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Constraint extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    // Unlike other plugin types, constraint IDs use camel case.
    $validator = new Chained(
      new Required(),
      new RegExp('/^[a-z][a-z0-9_]*[a-z0-9]$/i', 'The value is not correct constraint ID.'),
    );
    $vars['plugin_id'] = $ir->ask('Plugin ID', '{name|camelize}{plugin_label|camelize}', $validator);
    $unprefixed_plugin_id = Utils::removePrefix($vars['plugin_id'], Utils::camelize($vars['machine_name']));
    $vars['class'] = $ir->askPluginClass(default: $unprefixed_plugin_id . 'Constraint');

    $input_types = [
      'raw_value' => 'Raw value',
      'item' => 'Item',
      'item_list' => 'Item list',
      'entity' => 'Entity',
    ];
    $vars['input_type'] = $ir->choice('Type of data to validate', $input_types);

    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Plugin/Validation/Constraint/{class}.php')
      ->template('constraint.twig');

    $assets->addFile('src/Plugin/Validation/Constraint/{class}Validator.php')
      ->template('validator.twig');
  }

}
