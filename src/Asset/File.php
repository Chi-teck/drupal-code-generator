<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Simple data structure to represent a file being generated.
 */
final class File extends Asset {

  public const ACTION_REPLACE = 0x01;
  public const ACTION_PREPEND = 0x02;
  public const ACTION_APPEND = 0x03;
  public const ACTION_SKIP = 0x04;

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
   * Action.
   *
   * An action to take if specified file already exists.
   */
  private int $action = self::ACTION_REPLACE;

  /**
   * Header size.
   */
  private int $headerSize = 0;

  /**
   * Content resolver.
   *
   * @var callable|null
   */
  private $resolver = NULL;

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
   * Returns the asset action.
   */
  public function getAction(): int {
    return $this->action;
  }

  /**
   * Returns the asset header size (number of lines).
   */
  public function getHeaderSize(): int {
    return $this->headerSize;
  }

  /**
   * Returns the asset resolver.
   */
  public function getResolver(): ?callable {
    return $this->resolver;
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
   * Sets the "replace" action.
   */
  public function replaceIfExists(): self {
    $this->action = self::ACTION_REPLACE;
    return $this;
  }

  /**
   * Sets the "prepend" action.
   */
  public function prependIfExists(): self {
    $this->action = self::ACTION_PREPEND;
    return $this;
  }

  /**
   * Sets the "append" action.
   */
  public function appendIfExists(): self {
    $this->action = self::ACTION_APPEND;
    return $this;
  }

  /**
   * Sets the "skip" action.
   */
  public function skipIfExists(): self {
    $this->action = self::ACTION_SKIP;
    return $this;
  }

  /**
   * Set the asset header size.
   */
  public function headerSize(int $header_size): self {
    if ($header_size <= 0) {
      throw new \InvalidArgumentException('Header size must be greater than or equal to 0.');
    }
    $this->headerSize = $header_size;
    return $this;
  }

  /**
   * Setter for asset resolver.
   *
   * @param callable|null $resolver
   *   A callable responsible for resolving content.
   *   @code
   *     $resolver = static function (?string $existing_content, ?string $generated_content): ?string {
   *       if ($existing_content !== NULL) {
   *         return $generated_content . "\n" . $existing_content;
   *       }
   *       return $generated_content;
   *     }
   *   @endcode
   */
  public function resolver(?callable $resolver): self {
    $this->resolver = $resolver;
    return $this;
  }

  /**
   * Adds the Twig file extension if needed.
   */
  private static function addTwigFileExtension(string $template): string {
    if ($template && \pathinfo($template, \PATHINFO_EXTENSION) != 'twig') {
      $template .= '.twig';
    }
    return $template;
  }

}
