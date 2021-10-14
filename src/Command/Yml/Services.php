<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:services command.
 */
final class Services extends ModuleGenerator {

  protected string $name = 'yml:services';
  protected string $description = 'Generates a services yml file';
  protected string $alias = 'services';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/services';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = '{machine_name|camelize}';
    $this->addFile('{machine_name}.services.yml', 'services');
  }

}
