<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Twig;

use DrupalCodeGenerator\Utils;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Source;
use Twig\TokenStream;
use Twig\TwigFilter;

/**
 * Stores the Twig configuration.
 */
final class TwigEnvironment extends Environment {

  /**
   * Constructs Twig environment object.
   */
  public function __construct(FilesystemLoader $loader, array $options = []) {
    parent::__construct($loader, $options);

    $this->addTokenParser(new TwigSortTokenParser());

    $this->addFilter(new TwigFilter('pluralize', [Utils::class, 'pluralize']));
    $this->addFilter(new TwigFilter('camelize', [Utils::class, 'camelize']));

    $article = static function (string $input): string {
      $first_char = \strtolower($input[0]);
      $article = \in_array($first_char, ['a', 'e', 'i', 'o', 'u']) ? 'an' : 'a';
      return $article . ' ' . $input;
    };
    $this->addFilter(new TwigFilter('article', $article));

    $u2h = static fn (string $input): string => \str_replace('_', '-', $input);
    $this->addFilter(new TwigFilter('u2h', $u2h));

    $h2u = static fn (string $input): string => \str_replace('-', '_', $input);
    $this->addFilter(new TwigFilter('h2u', $h2u));

    $this->addFilter(new TwigFilter('m2h', [Utils::class, 'machine2human']));
    $this->addFilter(new TwigFilter('h2m', [Utils::class, 'human2machine']));
    $this->addFilter(new TwigFilter('c2m', [Utils::class, 'camel2machine']));

    $this->addGlobal('SUT_TEST', \getenv('SUT_TEST'));
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
    if (!\str_contains($code, '{% verbatim %}')) {
      $code = \preg_replace("/\n +\{%/", "\n{%", $source->getCode());
    }
    // Twig source has no setters.
    $source = new Source($code, $source->getName(), $source->getPath());
    return parent::tokenize($source);
  }

}
