<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Question\Question;

/**
 * Helper methods for code generators.
 */
class Utils {

  use LegacyUtilsTrait;

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
   * Transforms a camelized sting to machine name.
   */
  public static function camel2machine($input) {
    return self::human2machine(preg_replace('/[A-Z]/', ' \0', $input));
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
   * Service name validator.
   */
  public static function validateServiceName($value) {
    if ($value !== '' && !preg_match('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct service name.');
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
   * Returns a validator for allowed options.
   *
   * @param array $options
   *   Allowed values.
   *
   * @return callable
   *   Question validator.
   */
  public static function getOptionsValidator(array $options) {
    return function ($value) use ($options) {
      if (!in_array($value, $options)) {
        $options_formatted = implode(', ', $options);
        $error_message = sprintf('The value should be one of the following: %s.', $options_formatted);
        throw new \UnexpectedValueException($error_message);
      }
      return $value;
    };
  }

  /**
   * Returns default questions for module generators.
   *
   * @return \Symfony\Component\Console\Question\Question[]
   *   Array of module questions.
   */
  public static function moduleQuestions() {
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
   *   Array of plugin questions.
   */
  public static function pluginQuestions($class_suffix = '') {
    $questions['plugin_label'] = new Question('Plugin label', 'Example');
    $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);
    $questions['plugin_id'] = new Question('Plugin ID', [Utils::class, 'defaultPluginId']);
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);
    $questions['class'] = static::pluginClassQuestion($class_suffix);
    return $questions;
  }

  /**
   * Creates plugin class question.
   */
  public static function pluginClassQuestion($suffix = '') {
    $default_class = function ($vars) use ($suffix) {
      $unprefixed_plugin_id = preg_replace('/^' . $vars['machine_name'] . '_/', '', $vars['plugin_id']);
      return Utils::camelize($unprefixed_plugin_id) . $suffix;
    };
    return new Question('Plugin class', $default_class);
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
  public static function replaceTokens($text, array $data) {
    $tokens = [];
    foreach ($data as $var_name => $var) {
      if (is_string($var)) {
        $tokens['{' . $var_name . '}'] = $var;
      }
    }
    return str_replace(array_keys($tokens), array_values($tokens), $text);
  }

  /**
   * Pluralizes a noun.
   *
   * @param string $string
   *   A noun to pluralize.
   *
   * @return string
   *   The pluralized noun.
   */
  public static function pluralize($string) {
    switch (substr($string, -1)) {
      case 'y':
        return substr($string, 0, -1) . 'ies';

      case 's':
        return $string . 'es';

      default:
        return $string . 's';
    }
  }

  /**
   * Prepares choices.
   *
   * @param array $raw_choices
   *   The choices to be prepared.
   *
   * @return array
   *   The prepared choices.
   */
  public static function prepareChoices(array $raw_choices) {
    // The $raw_choices can be an associative array.
    $choices = array_values($raw_choices);
    // Start choices list form '1'.
    array_unshift($choices, NULL);
    unset($choices[0]);
    return $choices;
  }

}
