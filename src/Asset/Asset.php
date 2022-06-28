<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverDefinition;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;
use DrupalCodeGenerator\Utils;

/**
 * Base class for assets.
 */
abstract class Asset {

  /**
   * Indicates that the asset can be updated but never created.
   */
  private bool $virtual = FALSE;

  /**
   * Asset mode.
   */
  private int $mode;

  /**
   * Template variables.
   */
  private array $vars = [];

  /**
   * Content resolver.
   */
  protected ?ResolverInterface $resolver = NULL;

  /**
   * Resolver definition.
   */
  protected ResolverDefinition $resolverDefinition;

  /**
   * Asset constructor.
   */
  public function __construct(readonly protected string $path) {
    $this->resolverDefinition = new ResolverDefinition(ReplaceResolver::class);
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
   *
   * Virtual assets should not cause creating new directories, files or symlinks
   * on file system. They meant to be used by resolvers to update existing
   * objects.
   */
  final public function isVirtual(): bool {
    return $this->virtual;
  }

  /**
   * Returns the asset resolver.
   */
  public function getResolver(GeneratorStyleInterface $io): ResolverInterface {
    return $this->resolver ?? $this->resolverDefinition->createResolver($io);
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
   * Makes the asset "virtual".
   */
  final public function setVirtual(bool $virtual): self {
    $this->virtual = $virtual;
    return $this;
  }

  /**
   * Indicates that existing asset should be replaced.
   */
  final public function replaceIfExists(): self {
    $this->resolverDefinition = new ResolverDefinition(ReplaceResolver::class);
    return $this;
  }

  /**
   * Indicates that existing asset should be preserved.
   */
  final public function preserveIfExists(): self {
    $this->resolverDefinition = new ResolverDefinition(PreserveResolver::class);
    return $this;
  }

  /**
   * Setter for asset resolver.
   */
  final public function resolver(ResolverInterface $resolver): self {
    $this->resolver = $resolver;
    return $this;
  }

  /**
   * Implements the magic __toString() method.
   */
  final public function __toString(): string {
    return $this->getPath();
  }

  /**
   * Replaces all tokens in a given string with appropriate values.
   */
  final protected function replaceTokens(string $text): ?string {
    return Utils::replaceTokens($text, $this->vars);
  }

}
