<?php

namespace DrupalCodeGenerator\Commands\Drupal_6;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d6:module-info command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd6:module-info';
  protected $description = 'Generates Drupal 6 info file (module)';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '6.x-1.0-dev'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.info'] = $this->render('d6/module-info.twig', $vars);
  }

}
