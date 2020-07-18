<?php

namespace DrupalCodeGenerator\Command\Form;

/**
 * Implements form:simple command.
 */
final class Simple extends FormGenerator {

  protected $name = 'form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form';
  protected $defaultPermission = 'access content';
  protected $defaultClass = 'ExampleForm';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->generateRoute($vars);
    $this->addFile('src/Form/{class}.php', 'form');
  }

}
