<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Twig;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * A class that defines the compiler for 'sort' token.
 */
final class TwigSortSetNode extends Node {

  /**
   * {@inheritdoc}
   */
  public function compile(Compiler $compiler): void {
    $compiler
      ->addDebugInfo($this)
      ->write("ob_start();\n")
      ->subcompile($this->getNode('body'))
      ->write('$data = explode("\n", ob_get_clean());' . "\n")
      ->write('$data = array_unique($data);' . "\n")
      ->write('sort($data);' . "\n")
      ->write('echo ltrim(implode("\n", $data)) . "\n";' . "\n");
  }

}
