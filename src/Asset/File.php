<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\AppendResolver;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverDefinition;

/**
 * Simple data structure to represent a file being generated.
 */
final class File extends Asset {

  /**
   * Asset content.
   */
  private string $content = '';

  /**
   * Twig template to render header.
   */
  private ?string $headerTemplate = NULL;

  /**
   * Twig template to render main content.
   */
  private ?string $template = NULL;

  /**
   * The template string to render.
   */
  private ?string $inlineTemplate = NULL;

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
   * Returns the header template.
   */
  public function getHeaderTemplate(): ?string {
    return $this->headerTemplate ? $this->replaceTokens($this->headerTemplate) : $this->headerTemplate;
  }

  /**
   * Returns the asset template.
   */
  public function getTemplate(): ?string {
    return $this->template ? $this->replaceTokens($this->template) : $this->template;
  }

  /**
   * Returns the asset inline template.
   */
  public function getInlineTemplate(): ?string {
    return $this->inlineTemplate;
  }

  /**
   * Sets the asset content.
   */
  public function content(string $content): self {
    $this->content = $content;
    return $this;
  }

  /**
   * Sets the asset header template.
   */
  public function headerTemplate(?string $header_template): self {
    $this->headerTemplate = self::addTwigFileExtension($header_template);
    return $this;
  }

  /**
   * Sets the asset template.
   */
  public function template(?string $template): self {
    if ($template !== NULL) {
      $this->template = self::addTwigFileExtension($template);
    }
    return $this;
  }

  /**
   * Returns the asset inline template.
   */
  public function inlineTemplate(?string $inline_template): self {
    $this->inlineTemplate = $inline_template;
    return $this;
  }

  /**
   * Sets the "prepend" resolverAction.
   */
  public function prependIfExists(): self {
    $this->resolverDefinition = new ResolverDefinition(PrependResolver::class);
    return $this;
  }

  /**
   * Sets the "append" resolverAction.
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

}
