<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:module-info command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd8:yml:module-info';
  protected $description = 'Generates a module info yml file';
  protected $alias = 'module-info';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'description' => ['Description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'configure' => ['Configuration page (route name)', '', FALSE],
      'dependencies' => ['Dependencies (comma separated)', '', FALSE],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $this->files[$vars['machine_name'] . '.info.yml'] = $this->render('d8/yml/module-info.yml.twig', $vars);
  }

}
