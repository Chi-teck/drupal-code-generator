<?php declare(strict_types = 1);

namespace Drupal\example;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension.
 */
final class ExampleTwigExtension extends AbstractExtension {

  /**
   * Constructs the extension object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getFunctions(): array {
    $functions[] = new TwigFunction(
      'example',
      static function (string $argument): string {
        return 'Example: ' . $argument;
      },
    );
    return $functions;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters(): array {
    $filters[] = new TwigFilter(
      'example',
      static function (string $text): string {
        return str_replace('example', 'EXAMPLE', $text);
      },
    );
    return $filters;
  }

  /**
   * {@inheritdoc}
   */
  public function getTests(): array {
    $tests[] = new TwigTest(
      'example',
      static function (string $text): bool {
        return $text === 'example';
      },
    );
    return $tests;
  }

}
