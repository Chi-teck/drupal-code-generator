<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Twig;

use Twig\Node\Expression\TempNameExpression;
use Twig\Node\Node;
use Twig\Node\SetNode;
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
    \trigger_deprecation('chi-teck/drupal-code-generator', '3.6.0', 'The sort twig tag is deprecated and will be removed in 5.x, use the sort_namespaces twig filter.');
    $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(
      static fn (Token $token): bool => $token->test('endsort'),
      TRUE,
    );
    $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

    $lineno = $token->getLine();
    $name = $this->parser->getVarName();

    $ref = new TempNameExpression($name, $lineno);
    $ref->setAttribute('always_defined', TRUE);

    return new Node([
      new SetNode(TRUE, $ref, $body, $lineno, $this->getTag()),
      new TwigSortSetNode(['ref' => $ref], [], $lineno, $this->getTag()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getTag(): string {
    return 'sort';
  }

}
