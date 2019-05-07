<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d7:template.php command.
 */
class TemplatePhp extends ThemeGenerator {

  protected $name = 'd7:template.php';
  protected $description = 'Generates Drupal 7 template.php file';
  protected $alias = 'template.php';
  protected $label = 'template.php';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('template.php', 'd7/template.php');
  }

}
