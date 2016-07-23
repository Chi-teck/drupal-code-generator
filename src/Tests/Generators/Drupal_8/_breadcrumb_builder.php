<?php

namespace Drupal\example;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;

/**
 * Provides a breadcrumb builder for articles.
 */
class ExampleBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The node.
   *
   * @var \Drupal\node\NodeInterface
   */
  protected $node;

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $this->node = $route_match->getParameter('node');
    return $this->node instanceof NodeInterface && $this->node->getType() == 'article';
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();

    $links[] = Link::createFromRoute(t('Home'), '<front>');
    // Articles page is a view.
    $links[] = Link::createFromRoute(t('Articles'), 'view.articles.page_1');

    $links[] = Link::createFromRoute($this->node->label(), '<none>');

    $breadcrumb->setLinks($links);

    return $breadcrumb;
  }

}
