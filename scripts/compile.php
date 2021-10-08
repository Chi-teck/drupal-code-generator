#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * @file
 * Compiles DCG into a PHAR file.
 *
 * phpcs:ignoreFile Drupal.Commenting.FileComment.Missing
 */

set_error_handler(static function ($errno, $errstr, $errfile, $errline): void {
  fprintf(STDERR, "Error: %s on %s: %s\n", $errstr, $errfile, $errline);
  exit(1);
});

$name = 'dcg.phar';
$phar = new \Phar($name);
$phar->startBuffering();

$stub = <<< EOF
#!/usr/bin/env php
<?php

Phar::mapPhar('$name');
require 'phar://$name/bin/dcg';
__HALT_COMPILER();
EOF;

$phar->setStub($stub);

$files = array_merge(
  ['bin/dcg', 'LICENSE.txt'],
  dcg_scan_dir('src'),
  dcg_scan_dir('templates'),
  dcg_scan_dir('resources'),
  dcg_scan_dir('vendor', 'php'),
);
foreach ($files as $file) {
  $extension = pathinfo($file, PATHINFO_EXTENSION);
  $content = $extension == 'php' ?
    php_strip_whitespace($file) : file_get_contents($file);
  if ($file == 'bin/dcg') {
    $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);
  }
  $phar->addFromString($file, $content);
  printf("Added file: %s\n", $file);
}

$meta_data = [
  'build_time' => date('c'),
  'total_files' => count($files),
  'php_version' => PHP_VERSION,
];
$phar->setMetadata($meta_data);

$phar->stopBuffering();
print "---------------------------------\n";
printf("Total added: %s\n", count($files));
printf("PHAR file: %s\n", $phar->getPath());

/**
 * Recursively scans directory.
 */
function dcg_scan_dir(string $path, ?string $extension = NULL): array {
  $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
  $files = [];
  foreach ($iterator as $file) {
    if ($file->isDir() || ($extension && $extension != $file->getExtension())) {
      fprintf(STDERR, "\033[33mSkipped %s\033[0m\n", $file->getPathName());
      continue;
    }
    $files[] = $file->getPathname();
  }
  return $files;
}
