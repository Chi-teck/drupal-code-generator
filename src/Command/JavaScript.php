<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Implements javascript command.
 */
final class JavaScript extends ModuleGenerator {

  protected string $name = 'javascript';
  protected string $description = 'Generates Drupal JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('js/{machine_name|u2h}.js', 'javascript');
  }

}
