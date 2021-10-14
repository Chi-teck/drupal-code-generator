<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:routing command.
 */
final class Routing extends ModuleGenerator {

  protected string $name = 'yml:routing';
  protected string $description = 'Generates a routing yml file';
  protected string $alias = 'routing';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/routing';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = '{machine_name|camelize}Controller';
    $this->addFile('{machine_name}.routing.yml', 'routing');
  }

}
