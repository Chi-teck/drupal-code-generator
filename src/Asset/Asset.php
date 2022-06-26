<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Utils;

/**
 * Base class for assets.
 */
abstract class Asset {

  /**
   * Asset mode.
   */
  private int $mode;

  /**
   * Template variables.
   *
   * @var array
   */
  private array $vars = [];

  /**
   * Content resolver.
   *
   * @var callable|null
   */
  private $resolver = NULL;

  /**
   * Action.
   *
   * An resolverAction to take if specified file already exists.
   */
  private ResolverAction $resolverAction = ResolverAction::REPLACE;

  /**
   * Asset constructor.
   */
  public function __construct(protected string $path) {}

  /**
   * Assets named constructor.
   */
  final public static function create(string $path): static {
    return new static($path);
  }

  /**
   * Getter for the asset path.
   */
  final public function getPath(): string {
    return $this->replaceTokens($this->path);
  }

  /**
   * Getter for the asset mode.
   */
  final public function getMode(): int {
    return $this->mode;
  }

  /**
   * Getter for the asset vars.
   */
  final public function getVars(): array {
    return $this->vars;
  }

  /**
   * Returns the asset resolverAction.
   */
  final public function getResolverAction(): ResolverAction {
    return $this->resolverAction;
  }

  /**
   * Returns the asset resolver.
   */
  final public function getResolver(): ?callable {
    return $this->resolver;
  }

  /**
   * Setter for asset mode.
   */
  final public function mode(int $mode): Asset {
    if ($mode < 0000 || $mode > 0777) {
      throw new \InvalidArgumentException("Incorrect mode value $mode.");
    }
    $this->mode = $mode;
    return $this;
  }

  /**
   * Setter for the asset vars.
   */
  final public function vars(array $vars): self {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Sets the "replace" resolverAction.
   */
  public function replaceIfExists(): self {
    $this->resolverAction = ResolverAction::REPLACE;
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
   * Sets the "skip" resolverAction.
   */
  public function skipIfExists(): self {
    $this->resolverAction = ResolverAction::SKIP;
    return $this;
  }

  /**
   * Implements the magic __toString() method.
   */
  final public function __toString(): string {
    return $this->getPath();
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
  final public function resolver(?callable $resolver): self {
    $this->resolver = $resolver;
    return $this;
  }

  /**
   * Replaces all tokens in a given string with appropriate values.
   */
  final protected function replaceTokens(string $text): ?string {
    return Utils::replaceTokens($text, $this->vars);
  }

}
