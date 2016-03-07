<?php

namespace DrupalCodeGenerator\Commands;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Creates an instance of the plugin.
   *
   * @param array $twig_directories
   *   An array of directories where to look for templates.
   *
   * @return static
   *   An instance of the plugin.
   */
  public static function create(array $twig_directories);

}
