<?php

namespace Drupal\example;

/**
 * Twig extension.
 */
class ExampleTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'example';
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('foo', function($argument = NULL) {
        return 'Foo: ' . $argument;
      }),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    $filters = [
      new \Twig_SimpleFilter('bar',  function($text) {
        return str_replace('bar', 'BAR', $text);
      }),
    ];
    return $filters;
  }

  /**
   * {@inheritdoc}
   */
  public function getTests() {
    $tests = [
      new \Twig_SimpleTest('color', function($text) {
        return preg_match('/^#(?:[0-9a-f]{3}){1,2}$/i', $text);
      }),
    ];
    return $tests;
  }

}

