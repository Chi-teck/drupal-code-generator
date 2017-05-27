<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:template.php command.
 */
class TemplatePhp extends BaseGenerator {

  protected $name = 'd7:template.php';
  protected $description = 'Generates Drupal 7 template.php file';
  protected $alias = 'template.php';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Theme name'],
      'machine_name' => ['Theme machine name'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files['template.php'] = $this->render('d7/template.php.twig', $vars);
  }

}
