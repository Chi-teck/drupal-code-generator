<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:javascript command.
 */
final class JavaScript extends ModuleGenerator {

  protected string $name = 'misc:d7:javascript';
  protected string $description = 'Generates Drupal 7 JavaScript file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/javascript';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name|u2h}.js', 'javascript');
  }

}
