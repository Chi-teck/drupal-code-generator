<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Twig;

use Twig\Attribute\YieldReady;
use Twig\Compiler;
use Twig\Node\Node;

/**
 * A class that defines the compiler for 'sort' token.
 */
#[YieldReady]
final class TwigSortSetNode extends Node {

  /**
   * {@inheritdoc}
   */
  public function compile(Compiler $compiler): void {
    $compiler
      ->addDebugInfo($this)
      ->write('$getData = static fn () => ')
      ->subcompile($this->getNode('body'))
      ->write('$data = implode("", iterator_to_array(\$getData()));' . "\n")
      ->write('$data = explode("\n", $data);' . "\n")
      ->write('$data = array_unique($data);' . "\n")
      ->write('sort($data, SORT_FLAG_CASE|SORT_NATURAL);' . "\n")
      ->write('yield ltrim(implode("\n", $data)) . "\n";' . "\n");
  }

}
