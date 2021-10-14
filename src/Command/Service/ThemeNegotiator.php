<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:theme-negotiator command.
 */
final class ThemeNegotiator extends ModuleGenerator {

  protected string $name = 'service:theme-negotiator';
  protected string $description = 'Generates a theme negotiator';
  protected string $alias = 'theme-negotiator';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/theme-negotiator';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Negotiator');
    $this->addFile('src/Theme/{class}.php', 'theme-negotiator');
    $this->addServicesFile()->template('services');
  }

}
