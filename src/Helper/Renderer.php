<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Asset\RenderableInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Helper\Helper;
use Twig\Environment as TwigEnvironment;

/**
 * Output dumper form generators.
 */
final class Renderer extends Helper implements RendererInterface, LoggerAwareInterface {

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
   */
  public function render(string $template, array $vars): string {
    $this->logger->debug('Rendered template: {template}', ['template' => $template]);
    return $this->twig->render($template, $vars);
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
    /** @noinspection PhpPossiblePolymorphicInvocationInspection */
    $this->twig->getLoader()->prependPath($path);
  }

}
