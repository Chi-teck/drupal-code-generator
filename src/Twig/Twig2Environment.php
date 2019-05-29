<?php

namespace DrupalCodeGenerator\Twig;

use DrupalCodeGenerator\Utils;
use Twig\Source;
use Twig\TwigFilter;
use Twig\Loader\LoaderInterface;
use Twig\Environment;

/**
 * Stores the Twig configuration.
 */
class Twig2Environment extends Environment {

  /**
   * Constructs Twig environment object.
   *
   * @param \Twig\Loader\LoaderInterface $loader
   *   The Twig loader.
   */
  public function __construct(LoaderInterface $loader) {
    parent::__construct($loader);

    $this->addFilter(new TwigFilter('plural', [Utils::class, 'pluralize'], ['deprecated' => TRUE]));
    $this->addFilter(new TwigFilter('pluralize', [Utils::class, 'pluralize']));

    $this->addFilter(new TwigFilter('article', function ($string) {
      $article = in_array(strtolower($string[0]), ['a', 'e', 'i', 'o', 'u']) ? 'an' : 'a';
      return $article . ' ' . $string;
    }));

    $this->addFilter(new TwigFilter('underscore2hyphen', function ($string) {
      // @codeCoverageIgnoreStart
      return str_replace('_', '-', $string);
      // @codeCoverageIgnoreEnd
    }, ['deprecated' => TRUE]));

    $this->addFilter(new TwigFilter('hyphen2underscore', function ($string) {
      // @codeCoverageIgnoreStart
      return str_replace('-', '_', $string);
      // @codeCoverageIgnoreEnd
    }, ['deprecated' => TRUE]));

    $this->addFilter(new TwigFilter('u2h', function ($string) {
      return str_replace('_', '-', $string);
    }));

    $this->addFilter(new TwigFilter('h2u', function ($string) {
      return str_replace('-', '_', $string);
    }));

    $this->addFilter(new TwigFilter('camelize', function ($string, $upper_mode = TRUE) {
      return Utils::camelize($string, $upper_mode);
    }));

    $this->addTokenParser(new TwigSortTokenParser());
  }

  /**
   * {@inheritdoc}
   */
  public function tokenize(Source $source) {
    // Remove leading whitespaces to preserve indentation.
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
