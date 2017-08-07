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

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.layouts.yml'] = [
      'content' => $this->render('d8/_layout/layouts.twig', $vars),
      'action' => 'append',
    ];

    if ($vars['js'] || $vars['css']) {
      $this->files[$vars['machine_name'] . '.libraries.yml'] = [
        'content' => $this->render('d8/_layout/libraries.twig', $vars),
        'action' => 'append',
      ];
    }

    $path_prefix = 'layouts/' . $vars['layout_machine_name'] . '/';
    $layout_asset_name = str_replace('_', '-', $vars['layout_machine_name']);

    $this->setFile($path_prefix . $layout_asset_name . '.html.twig', 'd8/_layout/template.twig', $vars);

    if ($vars['js']) {
      $this->setFile($path_prefix . $layout_asset_name . '.js', 'd8/_layout/javascript.twig', $vars);
    }
    if ($vars['css']) {
      $this->setFile($path_prefix . $layout_asset_name . '.css', 'd8/_layout/styles.twig', $vars);
    }

  }

}
