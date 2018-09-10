<?php

namespace Drupal\foo\Plugin\Bar;

use Drupal\foo\BarPluginBase;

/**
 * Plugin implementation of the bar.
 *
 * @Bar(
 *   id = "foo",
 *   label = @Translation("Foo"),
 *   description = @Translation("Foo description.")
 * )
 */
class Foo extends BarPluginBase {

}
