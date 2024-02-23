<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Renderer;

use DrupalCodeGenerator\Asset\RenderableInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Twig\Environment as TwigEnvironment;

/**
 * Renders assets and templates using Twig template engine.
 */
final class TwigRenderer extends Helper implements RendererInterface, LoggerAwareInterface {

  use LoggerAwareTrait;

  /**
   * Constructs the Renderer object.
   */
  public function __construct(private readonly TwigEnvironment $twig) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'renderer';
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-suppress PossiblyNullReference
   */
  public function render(string $template, array $vars): string {
    if (\str_ends_with($template, '.twig')) {
      $output = $this->twig->render($template, $vars);
      $this->logger->debug('Rendered template: {template}', ['template' => $template]);
    }
    else {
      $file_name = $this->twig->resolveTemplate($template)->getSourceContext()->getPath();
      $output = \file_get_contents($file_name);
      $this->logger->debug('Copied source: {source}', ['source' => $file_name]);
    }
    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function renderInline(string $inline_template, array $vars): string {
    return $this->twig->createTemplate($inline_template)->render($vars);
  }

  /**
   * {@inheritdoc}
   */
  public function renderAsset(RenderableInterface $asset): void {
    $asset->render($this);
  }

  /**
   * {@inheritdoc}
   */
  public function registerTemplatePath(string $path): void {
    $loader = $this->twig->getLoader();
    /** @var \Twig\Loader\FilesystemLoader $loader */
    $loader->prependPath($path);
  }

}
