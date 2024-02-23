<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Bar;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\foo\Attribute\Bar;
use Drupal\foo\BarPluginBase;

/**
 * Plugin implementation of the bar.
 */
#[Bar(
  id: "foo",
  label: new TranslatableMarkup("Foo"),
  description: new TranslatableMarkup("Foo description."),
)]
final class Foo extends BarPluginBase {

}
