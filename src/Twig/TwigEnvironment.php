<?php

namespace DrupalCodeGenerator\Twig;

use DrupalCodeGenerator\Utils;
use Twig_Environment;
use Twig_LoaderInterface;
use Twig_SimpleFilter;

/**
 * Stores the Twig configuration.
 */
class TwigEnvironment extends Twig_Environment {

  /**
   * Constructs Twig environment object.
   *
   * @param \Twig_LoaderInterface $loader
   *   The Twig loader.
   */
  public function __construct(Twig_LoaderInterface $loader) {
    parent::__construct($loader);

    $this->addFilter(new Twig_SimpleFilter('plural', function ($string) {
      switch (substr($string, -1)) {
        case 'y':
          return substr($string, 0, -1) . 'ies';

        case 's':
          return $string . 'es';

        default:
          return $string . 's';
      }
    }));

    $this->addFilter(new Twig_SimpleFilter('article', function ($string) {
      $article = in_array(strtolower($string[0]), ['a', 'e', 'i', 'o', 'u']) ? 'an' : 'a';
      return $article . ' ' . $string;
    }));

    $this->addFilter(new Twig_SimpleFilter('underscore2hyphen', function ($string) {
      // @codeCoverageIgnoreStart
      return str_replace('_', '-', $string);
      // @codeCoverageIgnoreEnd
    }, ['deprecated' => TRUE]));

    $this->addFilter(new Twig_SimpleFilter('hyphen2underscore', function ($string) {
      // @codeCoverageIgnoreStart
      return str_replace('-', '_', $string);
      // @codeCoverageIgnoreEnd
    }, ['deprecated' => TRUE]));

    $this->addFilter(new Twig_SimpleFilter('u2h', function ($string) {
      return str_replace('_', '-', $string);
    }));

    $this->addFilter(new Twig_SimpleFilter('h2u', function ($string) {
      return str_replace('-', '_', $string);
    }));

    $this->addFilter(new Twig_SimpleFilter('camelize', function ($string, $upper_mode = TRUE) {
      return Utils::camelize($string, $upper_mode);
    }));

    $this->addTokenParser(new TwigSortTokenParser());
  }

  /**
   * {@inheritdoc}
   */
  public function tokenize($source, $name = NULL) {
    if (!$source instanceof \Twig_Source) {
      $source = new \Twig_Source($source, $name);
    }
    // Remove leading whitespaces to preserve indentation.
    // @see https://github.com/twigphp/Twig/issues/1423
    $code = preg_replace("/\n +\{%-/", "\n{%", $source->getCode());
    // Twig source has no setters.
    $source = new \Twig_Source($code, $source->getName(), $source->getPath());
    return parent::tokenize($source, $name);
  }

}
