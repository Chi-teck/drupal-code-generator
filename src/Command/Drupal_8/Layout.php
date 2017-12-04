<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:layout command.
 */
class Layout extends BaseGenerator {

  protected $name = 'd8:layout';
  protected $description = 'Generates a layout';
  protected $alias = 'layout';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions['machine_name'] = new Question('Extension machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $questions['layout_name'] = new Question('Layout name', 'Example');
    $questions['layout_machine_name'] = new Question('Layout machine name', function ($vars) {
      return Utils::human2machine($vars['layout_name']);
    });
    $questions['category'] = new Question('Category', 'My layouts');

    $questions['js'] = new ConfirmationQuestion('Would you like to create JavaScript file for this layout?', FALSE);
    $questions['css'] = new ConfirmationQuestion('Would you like to create CSS file for this layout?', FALSE);

    $vars = &$this->collectVars($input, $output, $questions);
    $this->addFile()
      ->path('{machine_name}.layouts.yml')
      ->template('d8/_layout/layouts.twig')
      ->action('append');

    if ($vars['js'] || $vars['css']) {
      $this->addFile()
        ->path('{machine_name}.libraries.yml')
        ->template('d8/_layout/libraries.twig')
        ->action('append');
    }

    $vars['layout_asset_name'] = str_replace('_', '-', $vars['layout_machine_name']);

    $this->addFile()
      ->path('layouts/{layout_machine_name}/{layout_asset_name}.html.twig')
      ->template('d8/_layout/template.twig');

    if ($vars['js']) {
      $this->addFile()
        ->path('layouts/{layout_machine_name}/{layout_asset_name}.js')
        ->template('d8/_layout/javascript.twig');
    }
    if ($vars['css']) {
      $this->addFile()
        ->path('layouts/{layout_machine_name}/{layout_asset_name}.css')
        ->template('d8/_layout/styles.twig');
    }

  }

}
