<?php

namespace Drupal\foo\Plugin\Foo;

use Drupal\foo\FooPluginBase;

/**
 * Example plugin implementation of the foo.
 *
 * @Foo(
 *   id = "example",
 *   label = @Translation("Example"),
 *   description = @Translation("Example description.")
 * )
 */
class Example extends FooPluginBase {

  /**
   * {@inheritdoc}
   */
  public function method1() {
    return __CLASS__ . ' implementation of ' . __FUNCTION__;
  }

}
