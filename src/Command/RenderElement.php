<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Implements render-element command.
 */
final class RenderElement extends ModuleGenerator {

  protected string $name = 'render-element';
  protected string $description = 'Generates Drupal render element';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Element/Entity.php', 'render-element');
  }

}
