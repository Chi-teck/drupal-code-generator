<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about Drupal configuration.
 */
final class ConfigInfo extends Helper {

  public function __construct(
    private readonly ConfigFactoryInterface $configFactory
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'config_info';
  }

  /**
   * Gets configuration object names.
   */
  public function getConfigNames(): array {
    return $this->configFactory->listAll();
  }

}
