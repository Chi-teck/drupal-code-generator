<?php declare(strict_types = 1);

namespace Drupal\foo\Theme;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

/**
 * Defines a theme negotiator that deals with the active theme on example page.
 */
final class FooNegotiator implements ThemeNegotiatorInterface {

  /**
   * Constructs the negotiator object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match): bool {
    return $route_match->getRouteName() === 'foo.example';
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match): ?string {
    // @DCG Here you can determine the active theme for the request.
    return 'claro';
  }

}
