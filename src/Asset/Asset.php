<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverDefinition;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Utils;

/**
 * Base class for assets.
 */
abstract class Asset implements \Stringable {

  /**
   * Indicates that the asset can be updated but never created.
   */
  private bool $virtual = FALSE;

  /**
   * Asset mode.
   *
   * @psalm-var int<0, 511>
   */
  private int $mode = 0444;

  /**
   * Template variables.
   *
   * @psalm-var array<string, mixed>
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
  public function __construct(protected readonly string $path) {
    // @todo Test this.
    match (TRUE) {
      $this instanceof Directory,
      $this instanceof File,
      $this instanceof Symlink => NULL,
      default => throw new \LogicException(\sprintf('%s class is internal for extension.', self::class)),
    };
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
   *
   * @psalm-return int<0, 511>
   */
  final public function getMode(): int {
    return $this->mode;
  }

  /**
   * Getter for the asset vars.
   *
   * @psalm-return array<string, mixed>
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
  public function getResolver(IO $io): ResolverInterface {
    return $this->resolver ?? $this->resolverDefinition->createResolver($io);
  }

  /**
   * Setter for asset mode.
   *
   * @psalm-param int<0, 511> $mode
   */
  final public function mode(int $mode): static {
    /** @psalm-suppress DocblockTypeContradiction */
    if ($mode < 0000 || $mode > 0777) {
      throw new \InvalidArgumentException('Incorrect mode value.');
    }
    $this->mode = $mode;
    return $this;
  }

  /**
   * Setter for the asset vars.
   *
   * @psalm-param array<string, mixed> $vars
   */
  final public function vars(array $vars): static {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Makes the asset "virtual".
   */
  final public function setVirtual(bool $virtual): static {
    $this->virtual = $virtual;
    return $this;
  }

  /**
   * Indicates that existing asset should be replaced.
   */
  final public function replaceIfExists(): static {
    $this->resolverDefinition = new ResolverDefinition(ReplaceResolver::class);
    return $this;
  }

  /**
   * Indicates that existing asset should be preserved.
   */
  final public function preserveIfExists(): static {
    $this->resolverDefinition = new ResolverDefinition(PreserveResolver::class);
    return $this;
  }

  /**
   * Setter for asset resolver.
   */
  final public function resolver(ResolverInterface $resolver): static {
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
  final protected function replaceTokens(string $input): string {
    return Utils::replaceTokens($input, $this->vars);
  }

}
