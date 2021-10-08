<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:module-libraries command.
 */
final class ModuleLibraries extends ModuleGenerator {

  protected string $name = 'yml:module-libraries';
  protected string $description = 'Generates module libraries yml file';
  protected string $alias = 'module-libraries';
  protected string $label = 'Libraries (module)';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.libraries.yml', 'module-libraries');
  }

}
