<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:render-element command.
 */
class RenderElement extends ModuleGenerator {

  protected $name = 'd8:render-element';
  protected $description = 'Generates Drupal 8 render element';
  protected $alias = 'render-element';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Element/Entity.php', 'd8/render-element.twig');
  }

}
