<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\views\field;

use Drupal\Component\Render\MarkupInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Provides Example field handler.
 *
 * @ViewsField("foo_example")
 *
 * @DCG
 * The plugin needs to be assigned to a specific table column through
 * hook_views_data() or hook_views_data_alter().
 * Put the following code to foo.views.inc file.
 * @code
 * function foo_views_data_alter(array &$data): void {
 *   $data['node']['foo_example']['field'] = [
 *     'title' => t('Example'),
 *     'help' => t('Custom example field.'),
 *     'id' => 'foo_example',
 *   ];
 * }
 * @endcode
 */
final class Example extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query(): void {
    // For non-existent columns (i.e. computed fields) this method must be
    // empty.
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values): string|MarkupInterface {
    $value = parent::render($values);
    // @todo Modify or replace the rendered value here.
    return $value;
  }

}
