<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements composer command.
 */
final class Composer extends DrupalGenerator {

  protected string $name = 'composer';
  protected string $description = 'Generates a composer.json file';
  protected string $alias = 'composer.json';
  protected string $label = 'composer.json';
  protected string $templatePath = Application::TEMPLATE_PATH . '/composer';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    // @see https://getcomposer.org/doc/04-schema.md#name
    $validator = static function (string $input): string {
      if (!\preg_match('#^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$#', $input)) {
        throw new \UnexpectedValueException('The package name sdsdf is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name.');
      }
      return $input;
    };
    $vars['project_name'] = $this->ask('Project name', 'drupal/example', $validator);
    [, $vars['machine_name']] = \explode('/', $vars['project_name']);

    $vars['description'] = $this->ask('Description');

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
    $vars['type'] = $this->choice('Project type', \array_combine($type_choices, $type_choices));

    $custom_types = [
      'drupal-custom-module',
      'drupal-custom-theme',
      'drupal-custom-profile',
    ];
    if (\in_array($vars['type'], $custom_types)) {
      $vars['drupal_org'] = FALSE;
    }
    else {
      // If project type is custom, there is no reason to ask this.
      $vars['drupal_org'] = $this->confirm('Is this project hosted on drupal.org?', FALSE);
    }

    $this->addFile('composer.json', 'composer');
  }

}
