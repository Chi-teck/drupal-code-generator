<?php

namespace DrupalCodeGenerator\Twig;

use DrupalCodeGenerator\Utils;
use Twig\Environment;
use Twig\Source;
use Twig\TokenStream;
use Twig\TwigFilter;
use Twig_LoaderInterface;

/**
 * Stores the Twig configuration.
 */
class TwigEnvironment extends Environment {

  /**
   * Constructs Twig environment object.
   *
   * @param \Twig_LoaderInterface $loader
   *   The Twig loader.
   * @param array $options
   *   (Optional) Environment options.
   */
  public function __construct(Twig_LoaderInterface $loader, array $options = []) {
    parent::__construct($loader, $options);

    $this->addTokenParser(new TwigSortTokenParser());

    $this->addFilter(new TwigFilter('pluralize', [Utils::class, 'pluralize']));
    $this->addFilter(new TwigFilter('camelize', [Utils::class, 'camelize']));

    $article = function (string $input): string {
      $first_char = strtolower($input[0]);
      $article = in_array($first_char, ['a', 'e', 'i', 'o', 'u']) ? 'an' : 'a';
      return $article . ' ' . $input;
    };
    $this->addFilter(new TwigFilter('article', $article));

    $u2h = function (string $input): string {
      return str_replace('_', '-', $input);
    };
    $this->addFilter(new TwigFilter('u2h', $u2h));

    $h2u = function (string $input): string {
      return str_replace('-', '_', $input);
    };
    $this->addFilter(new TwigFilter('h2u', $h2u));
  }

  /**
   * {@inheritdoc}
   */
  public function tokenize(Source $source): TokenStream {
    // Remove leading whitespaces to preserve indentation.
    // This has been resolved in Twig 2 but unfortunately neither PhpStorm nor
    // Twig Code sniffer supports this yet.
    // @see https://github.com/twigphp/Twig/issues/1423
    $code = $source->getCode();
    if (strpos($code, '{% verbatim %}') === FALSE) {
      $code = preg_replace("/\n +\{%/", "\n{%", $source->getCode());
    }
    // Twig source has no setters.
    $source = new Source($code, $source->getName(), $source->getPath());
    return parent::tokenize($source);
  }

}
