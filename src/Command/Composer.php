<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

/**
 * A generator for composer.json file.
 *
 * @todo Clean-up
 * @todo Define destination automatically based on project type.
 */
#[Generator(
  name: 'composer',
  description: 'Generates a composer.json file',
  aliases: ['composer.json'],
  templatePath: Application::TEMPLATE_PATH . '/_composer',
  type: GeneratorType::OTHER,
  label: 'composer.json',
)]
final class Composer extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    // @see https://getcomposer.org/doc/04-schema.md#name
    // @todo Test this.
    $validator = static function (string $input): string {
      if (!\preg_match('#^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$#', $input)) {
        throw new \UnexpectedValueException("The package name \"$input\" is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name.");
      }
      return $input;
    };
    $vars['project_name'] = $ir->ask('Project name', 'drupal/example', $validator);
    [, $vars['machine_name']] = \explode('/', $vars['project_name']);

    $vars['description'] = $ir->ask('Description');

    $type_choices = [
      'drupal-module',
      'drupal-custom-module',
      'drupal-theme',
      'drupal-custom-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-custom-profile',
      'drupal-drush',
    ];
    $vars['type'] = $ir->choice('Project type', \array_combine($type_choices, $type_choices));

    $vars['drupal_org'] = match($vars['type']) {
      'drupal-custom-module', 'drupal-custom-theme', 'drupal-custom-profile' => FALSE,
      default => $ir->confirm('Will this project be hosted on drupal.org?'),
    };

    $assets->addFile('composer.json', 'composer.twig');
  }

}
