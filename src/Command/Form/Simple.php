<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;

/**
 * Implements form:simple command.
 */
final class Simple extends FormGenerator {

  protected string $name = 'form:simple';
  protected string $description = 'Generates simple form';
  protected string $alias = 'form';
  protected string $templatePath = Application::TEMPLATE_PATH . '/form/simple';
  protected string $defaultPermission = 'access content';
  protected string $defaultClass = 'ExampleForm';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->generateRoute($vars);
    $this->addFile('src/Form/{class}.php', 'form');
  }

}
