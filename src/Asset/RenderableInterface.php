<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Helper\Renderer\RendererInterface;

/**
 * An interface for renderable assets.
 */
interface RenderableInterface {

  /**
   * Renders the asset.
   */
  public function render(RendererInterface $renderer): void;

}
