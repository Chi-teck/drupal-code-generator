<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

#[Generator(
  name: 'javascript',
  description: 'Generates Drupal JavaScript file',
  templatePath: Application::TEMPLATE_PATH . '/_javascript',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class JavaScript extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['file_name_full'] = $ir->ask('File name', '{machine_name|u2h}.js');
    $vars['file_name'] = \pathinfo($vars['file_name_full'], \PATHINFO_FILENAME);
    $vars['behavior'] = Utils::camelize($vars['machine_name'], FALSE) . Utils::camelize($vars['file_name']);

    if ($ir->confirm('Would you like to create a library for this file?')) {
      $vars['library'] = $ir->ask('Library name', '{file_name|h2u}');
      $assets->addFile('{machine_name}.libraries.yml', 'libraries.twig')
        ->appendIfExists();
    }

    $assets->addFile('js/{file_name_full}', 'javascript.twig');
  }

}
