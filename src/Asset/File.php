<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\AppendResolver;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverDefinition;
use DrupalCodeGenerator\Helper\Renderer\RendererInterface;

/**
 * A data structure to represent a file being generated.
 */
final class File extends Asset implements RenderableInterface {

  /**
   * Asset content.
   */
  private string $content = '';

  /**
   * Twig template to render main content.
   */
  private string $template;

  /**
   * The template string to render.
   */
  private string $inlineTemplate;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0644);
  }

  /**
   * Named constructor.
   */
  public static function create(string $path): self {
    return new self($path);
  }

  /**
   * Returns the asset content.
   */
  public function getContent(): string {
    return $this->content;
  }

  /**
   * Sets the asset content.
   */
  public function content(string $content): self {
    $this->content = $content;
    return $this;
  }

  /**
   * Sets the asset template.
   */
  public function template(string $template): self {
    if (isset($this->inlineTemplate)) {
      throw new \LogicException('A file cannot have both inline and regular templates.');
    }
    $this->template = self::addTwigFileExtension($template);
    return $this;
  }

  /**
   * Returns the asset inline template.
   */
  public function inlineTemplate(string $inline_template): self {
    if (isset($this->template)) {
      throw new \LogicException('A file cannot have both inline and regular templates.');
    }
    $this->inlineTemplate = $inline_template;
    return $this;
  }

  /**
   * Sets the "prepend" resolver.
   */
  public function prependIfExists(): self {
    $this->resolverDefinition = new ResolverDefinition(PrependResolver::class);
    return $this;
  }

  /**
   * Sets the "append" resolver.
   */
  public function appendIfExists(int $header_size = 0): self {
    $this->resolverDefinition = new ResolverDefinition(AppendResolver::class, $header_size);
    return $this;
  }

  /**
   * Adds the Twig file extension if needed.
   */
  private static function addTwigFileExtension(string $template): string {
    if ($template && \pathinfo($template, \PATHINFO_EXTENSION) !== 'twig') {
      $template .= '.twig';
    }
    return $template;
  }

  /**
   * {@inheritdoc}
   */
  public function render(RendererInterface $renderer): void {
    if (isset($this->inlineTemplate)) {
      $content = $renderer->renderInline($this->inlineTemplate, $this->getVars());
      $this->content($content);
    }
    elseif (isset($this->template)) {
      $template = $this->replaceTokens($this->template);
      $content = $renderer->render($template, $this->getVars());
      $this->content($content);
    }
    // It's OK that the file has no templates as consumers may set rendered
    // content directly through `content()` method.
  }

}
