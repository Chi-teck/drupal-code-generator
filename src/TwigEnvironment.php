<?php

namespace DrupalCodeGenerator;

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
      return str_replace('_', '-', $string);
    }));

    $this->addFilter(new Twig_SimpleFilter('hyphen2underscore', function ($string) {
      return str_replace('-', '_', $string);
    }));

    $this->addFilter(new Twig_SimpleFilter('camelize', function ($string, $upper_mode = TRUE) {
      return Utils::camelize($string, $upper_mode);
    }));
  }

}
