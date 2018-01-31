<?php

namespace Drupal\foo;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for foo plugins.
 */
abstract class FooPluginBase extends PluginBase implements FooInterface {

  /**
   * {@inheritdoc}
   */
  public function method1() {
    return 'default implementation of ' . __FUNCTION__;
  }

  /**
   * {@inheritdoc}
   */
  public function method2() {
    return 'default implementation of ' . __FUNCTION__;
  }

  /**
   * {@inheritdoc}
   */
  public function method3() {
    return 'default implementation of ' . __FUNCTION__;
  }

}
