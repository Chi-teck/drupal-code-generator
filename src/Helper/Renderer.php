<?php

namespace DrupalCodeGenerator\Helper;

use Symfony\Component\Console\Helper\Helper;
use Twig\Environment;

/**
 * Output dumper form generators.
 */
class Renderer extends Helper {

  /**
   * The twig environment.
   *
   * @var \Twig\Environment
   */
  protected $twig;

  /**
   * Constructs a generator command.
   *
   * @param \Twig\Environment $twig
   *   The twig environment.
   */
  public function __construct(Environment $twig) {
    $this->twig = $twig;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
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
  public function render($template, array $vars) {
    return $this->twig->render($template, $vars);
  }

  /**
   * Adds a path where templates are stored.
   *
   * @param string $path
   *   A path where to look for templates.
   */
  public function addPath($path) {
    return $this->twig->getLoader()->addPath($path);
  }

}
