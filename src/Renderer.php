<?php

namespace DrupalCodeGenerator;

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
   * Constructs a generator command.
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
  public function getName() {
    return 'renderer';
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

}
