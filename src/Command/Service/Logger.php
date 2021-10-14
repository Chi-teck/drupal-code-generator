<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:logger command.
 */
final class Logger extends ModuleGenerator {

  protected string $name = 'service:logger';
  protected string $description = 'Generates a logger service';
  protected string $alias = 'logger';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/logger';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'FileLog');
    $this->addFile('src/Logger/{class}.php', 'logger');
    $this->addServicesFile()->template('services');
  }

}
