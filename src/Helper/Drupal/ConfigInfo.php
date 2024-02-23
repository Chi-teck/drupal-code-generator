<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about Drupal configuration.
 */
final class ConfigInfo extends Helper {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ConfigFactoryInterface $configFactory,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'config_info';
  }

  /**
   * Gets configuration object names.
   *
   * @psalm-return list<string>
   * @psalm-suppress MoreSpecificReturnType
   */
  public function getConfigNames(): array {
    /** @psalm-suppress LessSpecificReturnStatement */
    return $this->configFactory->listAll();
  }

}
