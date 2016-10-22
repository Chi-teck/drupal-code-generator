<?php

/**
 * Generates hook templates from API documentation.
 *
 * This required modifying api_format_php() to make it return pure PHP code
 * without formatting.
 *
 * @see https://www.drupal.org/project/api
 */

$dir = '/tmp/hooks';
$branch_id = 1;

$query = db_query("SELECT object_name, code FROM {api_documentation} WHERE object_type = 'function' AND branch_id = ? AND object_name LIKE 'hook\_%'", [$branch_id]);
while ($hook = $query->fetch()) {
  $hook_name = str_replace('hook_', '', $hook->object_name);
  $comment = "/**\n * Implements {$hook->object_name}().\n */";
  $search = [
    "<?php",
    'function hook_',
    "?>"
  ];
  $replace = [
    $comment,
    'function {{ machine_name }}_',
    '',
  ];
  $code = str_replace($search, $replace, $hook->code);
  file_put_contents("$dir/$hook_name.twig", $code);
}
