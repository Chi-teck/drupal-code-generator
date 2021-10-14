<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

use DrupalCodeGenerator\Application;

/**
 * Implements form:confirm command.
 */
final class Confirm extends FormGenerator {

  protected string $name = 'form:confirm';
  protected string $description = 'Generates a confirmation form';
  protected string $alias = 'confirm-form';
  protected string $templatePath = Application::TEMPLATE_PATH . '/form/confirm';
  protected string $defaultPermission = 'administer site configuration';
  protected string $defaultClass = 'ExampleConfirmForm';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->generateRoute($vars);
    $this->addFile('src/Form/{class}.php', 'form');
  }

}
