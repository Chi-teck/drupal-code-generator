<?php

namespace DrupalCodeGenerator;

/**
 * Contains deprecated Utils methods.
 */
trait LegacyUtilsTrait {

  /**
   * Returns default questions for module generators.
   *
   * @return \Symfony\Component\Console\Question\Question[]
   *   Array of default questions.
   *
   * @deprecated Use Utils::moduleQuestions().
   */
  public static function defaultQuestions() :array {
    @trigger_error('Utils::defaultQuestions() method is deprecated.', E_USER_DEPRECATED);
    return static::moduleQuestions();
  }

  /**
   * Returns default questions for plugin generators.
   *
   * @return \Symfony\Component\Console\Question\Question[]
   *   Array of default questions.
   *
   * @deprecated Use Utils::moduleQuestions() and Utils::pluginQuestions().
   */
  public static function defaultPluginQuestions() :array {
    @trigger_error('Utils::defaultPluginQuestions() method is deprecated.', E_USER_DEPRECATED);
    $plugin_questions = static::pluginQuestions();
    // Plugin class question wasn't in original method implementation.
    unset($plugin_questions['class']);
    return static::moduleQuestions() + $plugin_questions;
  }

  /**
   * Returns normalized file path.
   *
   * @codeCoverageIgnore
   * @deprecated
   */
  public static function normalizePath(string $path) :string {
    $parts = [];
    $path = str_replace('\\', '/', $path);
    $path = preg_replace('/\/+/', '/', $path);
    $segments = explode('/', $path);
    foreach ($segments as $segment) {
      if ($segment != '.') {
        $test = array_pop($parts);
        if (is_null($test)) {
          $parts[] = $segment;
        }
        elseif ($segment == '..') {
          if ($test == '..') {
            $parts[] = $test;
          }
          if ($test == '..' || $test == '') {
            $parts[] = $segment;
          }
        }
        else {
          $parts[] = $test;
          $parts[] = $segment;
        }
      }
    }
    return implode('/', $parts);
  }

  /**
   * Replaces all tokens in a given string with appropriate values.
   *
   * @param string|null $text
   *   A string potentially containing replaceable tokens.
   * @param array $data
   *   An array where keys are token names and values are replacements.
   *
   * @return string
   *   Text with tokens replaced.
   *
   * @deprecated Use Utils::replaceTokens instead.
   */
  public static function tokenReplace(?string $text, array $data) :string {
    return static::replaceTokens($text, $data);
  }

}
