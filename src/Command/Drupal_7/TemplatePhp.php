<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
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
  protected function generate() :void {
    $questions['name'] = new Question('Theme name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('template.php')
      ->template('d7/template.php.twig');
  }

}
