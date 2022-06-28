<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;
use DrupalCodeGenerator\Utils;

/**
 * Base class for assets.
 */
abstract class Asset {

  /**
   * Indicates that the asset should not be dumped.
   */
  private bool $virtual = FALSE;

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
   */
  protected ?ResolverInterface $resolver = NULL;

  /**
   * Default resolver action.
   *
   * An action to take if specified file already exists.
   */
  protected ResolverAction $resolverAction = ResolverAction::REPLACE;

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
   * Checks if the asset is virtual.
   */
  final public function isVirtual(): bool {
    return $this->virtual;
  }

  /**
   * Returns the asset resolver.
   */
  abstract public function getResolver(GeneratorStyleInterface $io): ResolverInterface;

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
   * Sets virtual.
   */
  final public function setVirtual(bool $virtual): self {
    $this->virtual = $virtual;
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
   * Sets the "skip" resolverAction.
   */
  public function preserveIfExists(): self {
    $this->resolverAction = ResolverAction::PRESERVE;
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
   */
  final public function resolver(ResolverInterface $resolver): self {
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
