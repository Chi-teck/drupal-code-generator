<?php

namespace Drupal\foo;

use Drupal\example\ExampleInterface;

/**
 * Example service.
 */
class Example {

  /**
   * The example service.
   *
   * @var \Drupal\example\ExampleInterface
   */
  protected $example;

  /**
   * Constructs an example object.
   *
   * @param \Drupal\example\ExampleInterface $example
   *   The example service.
   */
  public function __construct(ExampleInterface $example) {
    $this->example = $example;
  }

  /**
   * Does something.
   */
  public function doSomething() {
    // @DCG place your code here.
  }

}
