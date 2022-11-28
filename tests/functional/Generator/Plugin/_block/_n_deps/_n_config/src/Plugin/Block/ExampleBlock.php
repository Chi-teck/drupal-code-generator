<?php declare(strict_types = 1);

namespace Drupal\foo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "foo_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Custom"),
 * )
 */
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
