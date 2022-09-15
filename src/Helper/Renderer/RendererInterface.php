<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Renderer;

use DrupalCodeGenerator\Asset\RenderableInterface;

/**
 * Renderer interface.
 */
interface RendererInterface {

  /**
   * Renders a template.
   *
   * Templates with 'twig' extension are processed with Twig template engine.
   *
   * @param string $template
   *   Path to a template.
   * @param array $vars
   *   Template variables.
   *
   * @return string
   *   Rendered content.
   */
  public function render(string $template, array $vars): string;

  /**
   * Renders a template string directly.
   *
   * @param string $inline_template
   *   The template string to render.
   * @param array $vars
   *   (Optional) Template variables.
   *
   * @return string
   *   A string representing the rendered output.
   */
  public function renderInline(string $inline_template, array $vars): string;

  /**
   * Renders an asset.
   *
   * @param \DrupalCodeGenerator\Asset\RenderableInterface $asset
   *   Asset to render.
   */
  public function renderAsset(RenderableInterface $asset): void;

  /**
   * Registers a path where templates are stored.
   *
   * @param string $path
   *   A path where to look for templates.
   */
  public function registerTemplatePath(string $path): void;

}
