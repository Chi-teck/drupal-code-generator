<?php

namespace DrupalCodeGenerator\Commands;

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
    return ucfirst(str_replace('_', ' ', $machine_name));
  }

  /**
   * Transforms a human name to machine name.
   */
  public static function human2machine($human_name) {
    return preg_replace(
      ['/^[0-9]/', '/[^a-z0-9_]+/'],
      '_',
      strtolower($human_name)
    );
  }

  /**
   * Transforms a human name to PHP class name.
   */
  public static function human2class($human_name) {
    return preg_replace(
      '/[^a-z0-9]/i',
      '',
      ucwords(str_replace('_', ' ', $human_name))
    );
  }

  /**
   * Machine name validator.
   */
  public static function validateMachineName($value) {
    if (!preg_match('/^[a-z]+[a-z0-9_]*$/', $value)) {
      return 'The value is not correct machine name.';
    }
  }

  /**
   * Class name validator.
   *
   * @see http://php.net/manual/en/language.oop5.basic.php
   */
  public static function validateClassName($value) {
    if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $value)) {
      return 'The value is not correct class name.';
    }
  }

  /**
   * Required value validator.
   */
  public static function validateRequired($value) {
    if ($value === NULL || $value === '') {
      return 'The value is required.';
    }
  }

  /**
   * Returns normalized file path.
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
   * Returns default questions.
   */
  public static function defaultQuestions() {
    return [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
    ];
  }

}
