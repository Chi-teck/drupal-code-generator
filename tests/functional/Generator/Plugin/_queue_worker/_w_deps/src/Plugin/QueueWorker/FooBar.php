<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\Attribute\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines 'example_foo_bar' queue worker.
 */
#[QueueWorker(
  id: 'example_foo_bar',
  title: new TranslatableMarkup('Test'),
  cron: ['time' => 60],
)]
final class FooBar extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new FooBar instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly ThemeNegotiatorInterface $themeNegotiator,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('theme.negotiator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data): void {
    // @todo Process data here.
  }

}
