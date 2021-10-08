<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements misc:d7:template.php command.
 */
final class TemplatePhp extends ThemeGenerator {

  protected $name = 'misc:d7:template.php';
  protected $description = 'Generates Drupal 7 template.php file';
  protected $alias = 'template.php';
  protected $label = 'template.php';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('template.php', 'template.php');
  }

}
