<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question;

/**
 * Helper methods for code generators.
 */
class Utils {

  /**
   * Creates default plugin ID.
   */
  public static function defaultPluginId(array $vars) {
    return $vars['machine_name'] . '_' . self::human2machine($vars['plugin_label']);
  }

  /**
   * Transforms a machine name to human name.
   */
  public static function machine2human($machine_name) {
    return ucfirst(trim(str_replace('_', ' ', $machine_name)));
  }

  /**
   * Transforms a human name to machine name.
   */
  public static function human2machine($human_name) {
    return trim(preg_replace(
      ['/^[0-9]+/', '/[^a-z0-9_]+/'],
      '_',
      strtolower($human_name)
    ), '_');
  }

  /**
   * Camelize a string.
   */
  public static function camelize($string, $upper_camel = TRUE) {
    $output = preg_replace('/([^A-Z])([A-Z])/', '$1 $2', $string);
    $output = strtolower($output);
    $output = preg_replace('/[^a-z0-9]/', ' ', $output);
    $output = trim($output);
    $output = ucwords($output);
    $output = str_replace(' ', '', $output);
    return $upper_camel ? $output : lcfirst($output);
  }

  /**
   * Machine name validator.
   */
  public static function validateMachineName($value) {
    if (!preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct machine name.');
    }
    return $value;
  }

  /**
   * Class name validator.
   *
   * @see http://php.net/manual/en/language.oop5.basic.php
   */
  public static function validateClassName($value) {
    if (!preg_match('/^[A-Z][a-zA-Z0-9]+$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct class name.');
    }
    return $value;
  }

  /**
   * Required value validator.
   */
  public static function validateRequired($value) {
    // FALSE is not considered as empty value because question helper use
    // it as negative answer on confirmation questions.
    if ($value === NULL || $value === '') {
      throw new \UnexpectedValueException('The value is required.');
    }
    return $value;
  }

  /**
   * Returns normalized file path.
   *
   * @codeCoverageIgnore
   * @deprecated
   */
  public static function normalizePath($path) {
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
   * Returns default questions for module generators.
   *
   * @return \Symfony\Component\Console\Question\Question[]
   *   Array of default questions.
   */
  public static function defaultQuestions() {
    $questions['name'] = new Question('Module name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    return $questions;
  }

  /**
   * Returns default questions for plugin generators.
   *
   * @return \Symfony\Component\Console\Question\Question[]
   *   Array of default questions.
   */
  public static function defaultPluginQuestions() {
    $questions = Utils::defaultQuestions();
    $questions['plugin_label'] = new Question('Plugin label', 'Example');
    $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);
    $questions['plugin_id'] = new Question('Plugin ID', [Utils::class, 'defaultPluginId']);
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);
    return $questions;
  }

  /**
   * Returns extension root.
   *
   * @return string|bool
   *   Extension root directory or false if it was not found.
   */
  public static function getExtensionRoot($directory) {
    $extension_root = FALSE;
    for ($i = 1; $i <= 5; $i++) {
      $info_file = $directory . '/' . basename($directory) . '.info';
      if ((file_exists($info_file) && basename($directory) !== 'drush') || file_exists($info_file . '.yml')) {
        $extension_root = $directory;
        break;
      }
      $directory = dirname($directory);
    }
    return $extension_root;
  }

  /**
   * Removes a given number of lines from the beginning of the string.
   */
  public static function removeHeader($content, $header_size) {
    return implode("\n", array_slice(explode("\n", $content), $header_size));
  }

  /**
   * Return the user's home directory.
   */
  public static function getHomeDirectory() {
    return isset($_SERVER['HOME']) ? $_SERVER['HOME'] : getenv('HOME');
  }

  /**
   * Replaces all tokens in a given string with appropriate values.
   *
   * @param string $text
   *   A string potentially containing replaceable tokens.
   * @param array $data
   *   An array where keys are token names and values are replacements.
   *
   * @return string
   *   Text with tokens replaced.
   */
  public static function tokenReplace($text, array $data) {
    $tokens = [];
    foreach ($data as $var_name => $var) {
      if (is_string($var)) {
        $tokens['{' . $var_name . '}'] = $var;
      }
    }
    return str_replace(array_keys($tokens), array_values($tokens), $text);
  }

}
