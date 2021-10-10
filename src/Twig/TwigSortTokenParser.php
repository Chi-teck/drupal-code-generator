<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Twig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * A class that defines the Twig 'sort' token parser.
 */
final class TwigSortTokenParser extends AbstractTokenParser {

  /**
   * {@inheritdoc}
   */
  public function parse(Token $token): TwigSortSetNode {

    $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(
      static fn (Token $token): bool => $token->test('endsort'),
      TRUE,
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
