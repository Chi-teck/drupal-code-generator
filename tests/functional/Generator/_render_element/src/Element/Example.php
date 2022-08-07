<?php declare(strict_types = 1);

namespace Drupal\foo\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element to display an example.
 *
 * Properties:
 * - #foo: Property description here.
 *
 * Usage Example:
 * @code
 * $build['example'] = [
 *   '#type' => 'example',
 *   '#foo' => 'Some value.',
 * ];
 * @endcode
 *
 * @RenderElement("example")
 */
final class Example extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo(): array {
    return [
      // @DCG
      // If the element is supposed to return a large piece of markup consider
      // defining a theme function for it.
      '#pre_render' => [
        [self::class, 'preRenderEntityElement'],
      ],
      // @DCG Define element properties here.
      '#foo' => 'bar',
    ];
  }

  /**
   * Example element pre render callback.
   *
   * @param array $element
   *   An associative array containing the properties of the example element.
   *
   * @return array
   *   The modified element.
   */
  public static function preRenderEntityElement(array $element): array {
    $element['#markup'] = $element['#foo'];
    return $element;
  }

}
