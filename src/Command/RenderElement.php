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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Element/Entity.php', 'render-element');
  }

}
