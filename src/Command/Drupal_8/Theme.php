<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:theme command.
 *
 * @TODO: Create a SUT test for this.
 */
class Theme extends BaseGenerator {

  protected $name = 'd8:theme';
  protected $description = 'Generates Drupal 8 theme';
  protected $alias = 'theme';
  protected $destination = 'themes';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['name'] = new Question('Theme name');
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['base_theme'] = new Question('Base theme', 'classy');
    $questions['description'] = new Question('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $questions['package'] = new Question('Package', 'Custom');
    $questions['sass'] = new ConfirmationQuestion('Would you like to use SASS to compile style sheets?', FALSE);
    $questions['breakpoints'] = new ConfirmationQuestion('Would you like to create breakpoints?', FALSE);
    $questions['theme_settings'] = new ConfirmationQuestion('Would you like to create theme settings form?', FALSE);

    $vars = $this->collectVars($input, $output, $questions);
    $vars['base_theme'] = Utils::human2machine($vars['base_theme']);

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];

    $this->addFile()
      ->path($prefix . '.info.yml')
      ->template('d8/yml/theme-info.twig');

    $this->addFile()
      ->path($prefix . '.libraries.yml')
      ->template('d8/yml/theme-libraries.twig');

    $this->addFile()
      ->path($prefix . '.theme')
      ->template('d8/theme.twig');

    $this->addFile()
      ->path('{machine_name}/js/' . str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d8/javascript.twig');

    if ($vars['breakpoints']) {
      $this->addFile()
        ->path($prefix . '.breakpoints.yml')
        ->template('d8/yml/breakpoints.twig');
    }

    if ($vars['theme_settings']) {
      $this->addFile()
        ->path('{machine_name}/theme-settings.php')
        ->template('d8/theme-settings-form.twig');

      $this->addFile()
        ->path('{machine_name}/config/install/{machine_name}.settings.yml')
        ->template('d8/theme-settings-config.twig');

      $this->addFile()
        ->path('{machine_name}/config/schema/{machine_name}.schema.yml')
        ->template('d8/theme-settings-schema.twig');
    }

    $this->addFile()
      ->path('{machine_name}/logo.svg')
      ->template('d8/theme-logo.twig');

    // Templates directory structure.
    $this->addDirectory()
      ->path('{machine_name}/templates/page');

    $this->addDirectory()
      ->path('{machine_name}/templates/node');

    $this->addDirectory()
      ->path('{machine_name}/templates/field');

    $this->addDirectory()
      ->path('{machine_name}/templates/view');

    $this->addDirectory()
      ->path('{machine_name}/templates/block');

    $this->addDirectory()
      ->path('{machine_name}/templates/menu');

    $this->addDirectory()
      ->path('{machine_name}/images');

    $this->addFile()
      ->path('{machine_name}/package.json')
      ->template('d8/theme-package.json.twig');

    // Style sheets directory structure.
    $this->addDirectory()
      ->path('{machine_name}/css');

    $style_sheets = [
      'base/elements',
      'components/block',
      'components/breadcrumb',
      'components/field',
      'components/form',
      'components/header',
      'components/menu',
      'components/messages',
      'components/node',
      'components/sidebar',
      'components/table',
      'components/tabs',
      'components/buttons',
      'layouts/layout',
      'theme/print',
    ];

    foreach ($style_sheets as $file) {
      $this->addFile()
        ->path('{machine_name}/' . ($vars['sass'] ? "scss/$file.scss" : "css/$file.css"))
        ->content('');
    }

  }

}
