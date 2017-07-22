<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Theme;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:theme:standard command.
 *
 * @TODO: Create a test for this.
 */
class Standard extends BaseGenerator {

  protected $name = 'd8:theme:standard';
  protected $description = 'Generates standard Drupal 8 theme';
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
    $this->setFile($prefix . '.info.yml', 'd8/yml/theme-info.twig', $vars);
    $this->setFile($prefix . '.libraries.yml', 'd8/yml/theme-libraries.twig', $vars);
    $this->setFile($prefix . '.breakpoints.yml', 'd8/yml/breakpoints.twig', $vars);
    $this->setFile($prefix . '.theme', 'd8/theme.twig', $vars);

    $js_path = $vars['machine_name'] . '/js/' . str_replace('_', '-', $vars['machine_name']) . '.js';
    $this->setFile($js_path, 'd8/javascript.twig', $vars);

    $settings_form_path = $vars['machine_name'] . '/theme-settings.php';
    $this->setFile($settings_form_path, 'd8/theme-settings-form.twig', $vars);

    $settings_config_path = $vars['machine_name'] . '/config/install/' . $vars['machine_name'] . '.settings.yml';
    $this->setFile($settings_config_path, 'd8/theme-settings-config.twig', $vars);

    $settings_schema_path = $vars['machine_name'] . '/config/schema/' . $vars['machine_name'] . '.schema.yml';
    $this->setFile($settings_schema_path, 'd8/theme-settings-schema.twig', $vars);

    $this->setFile($vars['machine_name'] . '/logo.svg', 'd8/theme/standard/logo.twig', $vars);

    $this->files[$vars['machine_name'] . '/templates'] = NULL;
    $this->files[$vars['machine_name'] . '/images'] = NULL;

    $this->files[$vars['machine_name'] . '/css/base/elements.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/block.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/breadcrumb.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/field.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/form.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/header.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/menu.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/messages.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/node.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/sidebar.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/table.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/tabs.css'] = '';
    $this->files[$vars['machine_name'] . '/css/components/buttons.css'] = '';
    $this->files[$vars['machine_name'] . '/css/layouts/layout.css'] = '';
    $this->files[$vars['machine_name'] . '/css/theme/print.css'] = '';
  }

}
