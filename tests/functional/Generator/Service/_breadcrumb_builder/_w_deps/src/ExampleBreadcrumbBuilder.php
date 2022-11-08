<?php declare(strict_types = 1);

namespace Drupal\example;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * @todo Add description for this breadcrumb builder.
 */
final class ExampleBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  use StringTranslationTrait;

  /**
   * Constructs an ExampleBreadcrumbBuilder object.
   */
  public function __construct(
    private readonly CronInterface $cron,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match): bool {
    return $route_match->getRouteName() === 'example';
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match): Breadcrumb {
    $breadcrumb = new Breadcrumb();

    $links[] = Link::createFromRoute($this->t('Home'), '<front>');
    $links[] = Link::createFromRoute($this->t('Example'), '<none>');

    return $breadcrumb->setLinks($links);
  }

}
