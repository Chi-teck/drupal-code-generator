<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Twig;

use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * A class that defines the Twig 'sort' token parser.
 */
final class TwigSortTokenParser extends AbstractTokenParser {

  /**
   * {@inheritdoc}
   */
  public function parse(Token $token): Node {
    throw new SyntaxError('The sort tag been deleted in 4.x version use the sort_namespaces twig filter.', $token->getLine());
  }

  /**
   * {@inheritdoc}
   */
  public function getTag(): string {
    return 'sort';
  }

}
