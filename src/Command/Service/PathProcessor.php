<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:path-processor command.
 */
final class PathProcessor extends ModuleGenerator {

  protected string $name = 'service:path-processor';
  protected string $description = 'Generates a path processor service';
  protected string $alias = 'path-processor';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/path-processor';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'PathProcessor{machine_name|camelize}');

    $this->addFile('src/PathProcessor/{class}.php', 'path-processor');
    $this->addServicesFile()->template('services');
  }

}
