<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:middleware command.
 */
final class Middleware extends ModuleGenerator {

  protected string $name = 'service:middleware';
  protected string $description = 'Generates a middleware';
  protected string $alias = 'middleware';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/middleware';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Middleware');
    $this->addFile('src/{class}.php', 'middleware');
    $this->addServicesFile()->template('services');
  }

}
