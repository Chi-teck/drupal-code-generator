<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service-provider',
  description: 'Generates a service provider',
  templatePath: Application::TEMPLATE_PATH . '/_service-provider',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ServiceProvider extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['provide'] = $ir->confirm('Would you like to provide new services?');
    $vars['modify'] = $ir->confirm('Would you like to modify existing services?');

    if (!$vars['provide'] && !$vars['modify']) {
      $this->io()->newLine();
      $this->io()->writeln('<comment>Congratulations! You don\'t need a service provider.</comment>');
      $this->io()->newLine();
      return;
    }

    $interfaces = [
      'ServiceProviderInterface' => $vars['provide'],
      'ServiceModifierInterface' => $vars['modify'],
    ];
    $vars['interfaces'] = \array_keys(\array_filter($interfaces));

    // The class names is required to be a CamelCase version of the module's
    // machine name followed by ServiceProvider.
    // @see https://www.drupal.org/node/2026959
    $vars['class'] = '{machine_name|camelize}ServiceProvider';
    $assets->addFile('src/{class}.php', 'service-provider.twig');
  }

}
