<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides an example block.
 */
#[Block(
  id: 'foo_example',
  admin_label: new TranslatableMarkup('Example'),
  category: new TranslatableMarkup('Custom'),
)]
final class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
