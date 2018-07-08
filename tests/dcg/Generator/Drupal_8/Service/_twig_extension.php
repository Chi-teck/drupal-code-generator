<?php

namespace Drupal\example;

use Drupal\example\ExampleInterface;

/**
 * Twig extension.
 */
class ExampleTwigExtension extends \Twig_Extension {

  /**
   * The example service.
   *
   * @var \Drupal\example\ExampleInterface
   */
  protected $example;

  /**
   * Constructs a new ExampleTwigExtension instance.
   *
   * @param \Drupal\example\ExampleInterface $example
   *   The example service.
   */
  public function __construct(ExampleInterface $example) {
    $this->example = $example;
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('foo', function ($argument = NULL) {
        return 'Foo: ' . $argument;
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('bar', function ($text) {
        return str_replace('bar', 'BAR', $text);
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTests() {
    return [
      new \Twig_SimpleTest('color', function ($text) {
        return preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $text);
      }),
    ];
  }

}
