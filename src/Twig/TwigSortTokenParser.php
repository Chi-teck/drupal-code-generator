<?php

namespace DrupalCodeGenerator\Twig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * A class that defines the Twig 'sort' token parser.
 */
class TwigSortTokenParser extends AbstractTokenParser {

  /**
   * {@inheritdoc}
   */
  public function parse(Token $token): TwigSortSetNode {

    $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(
      function (Token $token) {
        return $token->test('endsort');
      },
      TRUE
    );
    $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

    return new TwigSortSetNode(['body' => $body], [], $token->getLine(), $this->getTag());
  }

  /**
   * {@inheritdoc}
   */
  public function getTag(): string {
    return 'sort';
  }

}
