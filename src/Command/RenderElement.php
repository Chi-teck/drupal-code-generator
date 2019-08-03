<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements render-element command.
 */
final class RenderElement extends ModuleGenerator {

  protected $name = 'render-element';
  protected $description = 'Generates Drupal 8 render element';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $this->collectDefault();
    $this->addFile('src/Element/Entity.php', 'render-element');
  }

}
