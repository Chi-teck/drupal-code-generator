<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:permissions command.
 */
final class Permissions extends ModuleGenerator {

  protected string $name = 'yml:permissions';
  protected string $description = 'Generates a permissions yml file';
  protected string $alias = 'permissions';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/permissions';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.permissions.yml', 'permissions');
  }

}
