<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use Symfony\Component\Console\Question\Question;

/**
 * Implements composer command.
 */
final class Composer extends DrupalGenerator {

  protected string $name = 'composer';
  protected string $description = 'Generates a composer.json file';
  protected string $alias = 'composer.json';
  protected string $label = 'composer.json';
  protected string $templatePath = Application::TEMPLATE_PATH . '/composer';
  protected ?string $nameQuestion = NULL;
  protected ?string $machineNameQuestion = 'Project machine name';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['description'] = $this->ask('Description');

    $type_question = new Question('Type', 'drupal-module');
    $type_question->setValidator([self::class, 'validateRequired']);
    $type_question->setAutocompleterValues([
      'drupal-module',
      'drupal-custom-module',
      'drupal-theme',
      'drupal-custom-theme',
      'drupal-library',
      'drupal-profile',
      'drupal-custom-profile',
      'drupal-drush',
    ]);
    $vars['type'] = $this->io->askQuestion($type_question);

    $custom_types = [
      'drupal-custom-module',
      'drupal-custom-theme',
      'drupal-custom-profile',
    ];
    if (!\in_array($vars['type'], $custom_types)) {
      // If project type is custom, there is no reason to ask this.
      $vars['drupal_org'] = $this->confirm('Is this project hosted on drupal.org?', FALSE);
    }
    else {
      $vars['drupal_org'] = FALSE;
    }

    $this->addFile('composer.json', 'composer');
  }

}
