<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements render-element command.
 */
final class RenderElement extends ModuleGenerator {

  protected string $name = 'render-element';
  protected string $description = 'Generates Drupal render element';
  protected ?string $nameQuestion = NULL;
  protected string $templatePath = Application::TEMPLATE_PATH . '/render-element';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Element/Entity.php', 'render-element');
  }

}
