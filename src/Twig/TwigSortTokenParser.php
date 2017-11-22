<?php

namespace DrupalCodeGenerator\Twig;

use Twig_TokenParser;
use Twig_Token;

/**
 * A class that defines the Twig 'sort' token parser.
 */
class TwigSortTokenParser extends Twig_TokenParser {

  /**
   * {@inheritdoc}
   */
  public function parse(Twig_Token $token) {

    $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(
      function (Twig_Token $token) {
        return $token->test('endsort');
      },
      TRUE
    );
    $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

    return new TwigSortSetNode(['body' => $body], [], $token->getLine(), $this->getTag());
  }

  /**
   * {@inheritdoc}
   */
  public function getTag() {
    return 'sort';
  }

}
