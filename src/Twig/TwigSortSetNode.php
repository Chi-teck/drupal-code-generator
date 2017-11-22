<?php

namespace DrupalCodeGenerator\Twig;

use Twig_Node;
use Twig_Compiler;

/**
 * A class that defines the compiler for 'sort' token.
 */
class TwigSortSetNode extends Twig_Node {

  /**
   * {@inheritdoc}
   */
  public function compile(Twig_Compiler $compiler) {
    $compiler
      ->addDebugInfo($this)
      ->write("ob_start();\n")
      ->subcompile($this->getNode('body'))
      ->write('$data = explode("\n", ob_get_clean());' . "\n")
      ->write('sort($data);' . "\n")
      ->write('echo ltrim(implode("\n", $data)) . "\n";' . "\n");
  }

}
