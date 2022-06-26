<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\AppendResolver;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;
use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Simple data structure to represent a file being generated.
 */
final class File extends Asset {

  /**
   * Asset content.
   */
  private ?string $content = NULL;

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
   * Header size.
   */
  private int $headerSize = 0;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0644);
  }

  /**
   * Returns the asset content.
   */
  public function getContent(): ?string {
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
   * Returns the asset header size (number of lines).
   */
  public function getHeaderSize(): int {
    return $this->headerSize;
  }

  /**
   * Indicated that the exising content should be prepended with this one.
   */
  final public function shouldPrepend(): bool {
    return $this->resolverAction === ResolverAction::PREPEND;
  }

  /**
   * Indicated that the exising content should be appended with this one.
   */
  final public function shouldAppend(): bool {
    return $this->resolverAction === ResolverAction::APPEND;
  }

  /**
   * Sets the asset content.
   */
  public function content(?string $content): self {
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
   * Returns the asset template.
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
   * Set the asset header size.
   */
  public function headerSize(int $header_size): self {
    if ($header_size < 0) {
      throw new \InvalidArgumentException('Header size must be greater than or equal to 0.');
    }
    $this->headerSize = $header_size;
    return $this;
  }

  /**
   * Sets the "prepend" resolverAction.
   */
  public function prependIfExists(): self {
    $this->resolverAction = ResolverAction::PREPEND;
    return $this;
  }

  /**
   * Sets the "append" resolverAction.
   */
  public function appendIfExists(): self {
    $this->resolverAction = ResolverAction::APPEND;
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
   * {@inheritDoc}
   */
  public function getResolver(GeneratorStyleInterface $io, DumperOptions $options): ResolverInterface {
    return $this->resolver ?? match ($this->resolverAction) {
      ResolverAction::PRESERVE => new PreserveResolver(),
      ResolverAction::REPLACE => new ReplaceResolver($options, $io),
      ResolverAction::PREPEND => new PrependResolver(),
      ResolverAction::APPEND => new AppendResolver(),
    };
  }

}
