<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:template.php command.
 */
class TemplatePhp extends BaseGenerator {

  protected $name = 'd7:template.php';
  protected $description = 'Generates Drupal 7 template.php file';
  protected $alias = 'template.php';
  protected $label = 'template.php';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['name'] = new Question('Theme name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile('template.php', 'd7/template.php.twig', $vars);
  }

}
