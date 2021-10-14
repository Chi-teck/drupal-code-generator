<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements misc:d7:template.php command.
 */
final class TemplatePhp extends ThemeGenerator {

  protected string $name = 'misc:d7:template.php';
  protected string $description = 'Generates Drupal 7 template.php file';
  protected string $alias = 'template.php';
  protected string $label = 'template.php';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/template.php';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('template.php', 'template.php');
  }

}
