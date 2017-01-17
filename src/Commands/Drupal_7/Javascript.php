<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd7:javascript';
  protected $description = 'Generates Drupal 7 javascript file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $vars['project_type'] = 'module';
    $this->files[$vars['machine_name'] . '.js'] = $this->render('d7/javascript.twig', $vars);
  }

}
