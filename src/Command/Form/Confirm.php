<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Form;

/**
 * Implements form:confirm command.
 */
final class Confirm extends FormGenerator {

  protected $name = 'form:confirm';
  protected $description = 'Generates a confirmation form';
  protected $alias = 'confirm-form';
  protected $defaultPermission = 'administer site configuration';
  protected $defaultClass = 'ExampleConfirmForm';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->generateRoute($vars);
    $this->addFile('src/Form/{class}.php', 'form');
  }

}
