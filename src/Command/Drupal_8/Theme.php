<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:theme command.
 *
 * @TODO: Create a test for this.
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
      ->path($prefix . '.breakpoints.yml')
      ->template('d8/yml/breakpoints.twig');

    $this->addFile()
      ->path($prefix . '.theme')
      ->template('d8/theme.twig');

    $this->addFile()
      ->path('{machine_name}/js/' . str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d8/javascript.twig');

    $this->addFile()
      ->path('{machine_name}/theme-settings.php')
      ->template('d8/theme-settings-form.twig');

    $this->addFile()
      ->path('{machine_name}/config/install/{machine_name}.settings.yml')
      ->template('d8/theme-settings-config.twig');

    $this->addFile()
      ->path('{machine_name}/config/schema/{machine_name}.schema.yml')
      ->template('d8/theme-settings-schema.twig');

    $this->addFile()
      ->path('{machine_name}/logo.svg')
      ->template('d8/theme-logo.twig');

    $this->addDirectory()
      ->path('{machine_name}/templates');

    $this->addDirectory()
      ->path('{machine_name}/images');

    $css_files = [
      'base/elements.css',
      'components/block.css',
      'components/breadcrumb.css',
      'components/field.css',
      'components/form.css',
      'components/header.css',
      'components/menu.css',
      'components/messages.css',
      'components/node.css',
      'components/sidebar.css',
      'components/table.css',
      'components/tabs.css',
      'components/buttons.css',
      'layouts/layout.css',
      'theme/print.css',
    ];
    foreach ($css_files as $file) {
      $this->addFile()
        ->path('{machine_name}/css/' . $file)
        ->content('');
    }

  }

}
