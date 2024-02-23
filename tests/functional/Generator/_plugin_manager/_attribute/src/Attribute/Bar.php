<?php

declare(strict_types=1);

namespace Drupal\foo\Attribute;

use Drupal\Component\Plugin\Attribute\AttributeBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * The bar attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class Bar extends AttributeBase {

  /**
   * Constructs a new Bar instance.
   */
  public function __construct(
    public readonly string $id,
    public readonly ?TranslatableMarkup $label,
    public readonly ?TranslatableMarkup $description = NULL,
  ) {}

}
