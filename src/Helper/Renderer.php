<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset;
use Symfony\Component\Console\Helper\Helper;
use Twig_Environment;

/**
 * Output dumper form generators.
 */
class Renderer extends Helper {

  /**
   * The twig environment.
   *
   * @var \Twig_Environment
   */
  protected $twig;

  /**
   * Constructs the Renderer object.
   *
   * @param \Twig_Environment $twig
   *   The twig environment.
   */
  public function __construct(Twig_Environment $twig) {
    $this->twig = $twig;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'dcg_renderer';
  }

  /**
   * Renders a template.
   *
   * @param string $template
   *   Twig template.
   * @param array $vars
   *   Template variables.
   *
   * @return string
   *   A string representing the rendered output.
   */
  public function render(string $template, array $vars) :string {
    return $this->twig->render($template, $vars);
  }

  /**
   * Renders an asset.
   *
   * @param \DrupalCodeGenerator\Asset $asset
   *   Asset to render.
   */
  public function renderAsset(Asset $asset) :void {
    if ($asset->isFile() && $asset->getTemplate()) {
      $content = '';
      if ($header_template = $asset->getHeaderTemplate()) {
        $content .= $this->render($header_template, $asset->getVars()) . "\n";
      }
      $content .= $this->render($asset->getTemplate(), $asset->getVars());
      $asset->content($content);
    }
  }

  /**
   * Adds a path where templates are stored.
   *
   * @param string $path
   *   A path where to look for templates.
   */
  public function addPath(string $path) :void {
    $this->twig->getLoader()->addPath($path);
  }

}
