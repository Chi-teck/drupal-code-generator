<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'plugin:filter',
  description: 'Generates filter plugin',
  aliases: ['filter'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_filter',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Filter extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();

    $filter_types = [
      'TYPE_HTML_RESTRICTOR' => 'HTML restrictor',
      'TYPE_MARKUP_LANGUAGE' => 'Markup language',
      'TYPE_TRANSFORM_IRREVERSIBLE' => 'Irreversible transformation',
      'TYPE_TRANSFORM_REVERSIBLE' => 'Reversible transformation',
    ];
    $vars['filter_type'] = $ir->choice('Filter type', $filter_types);
    $vars['configurable'] = $ir->confirm('Make the filter configurable?', FALSE);
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Plugin/Filter/{class}.php', 'filter.twig');
    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema.twig');
    }
  }

}
