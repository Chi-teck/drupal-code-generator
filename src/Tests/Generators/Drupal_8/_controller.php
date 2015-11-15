<?php

/**
 * @file
 * Contains \Drupal\example\Controller\ExampleController.
 */

namespace Drupal\example\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Returns responses for Example routes.
 */
class ExampleController extends ControllerBase {

  /**
   * The date formatter service.
   *
   * @var DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter')
    );
  }

  /**
   * Constructs a FooController object.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(DateFormatterInterface $date_formatter) {
    $this->dateFormatter = $date_formatter;
  }

  /**
   * Displays the site status report.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#title' => t('Content'),
      '#markup' => t('Hello world!'),
    ];

    $build['date'] = [
      '#type' => 'item',
      '#title' => t('Date'),
      '#markup' => $this->dateFormatter->format(REQUEST_TIME),
    ];

    return $build;
  }

}
