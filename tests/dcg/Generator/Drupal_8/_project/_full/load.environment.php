<?php

/**
 * @file
 * Loads environment variables from .env files.
 *
 * This file is included very early.
 * @see composer.json For autoload section.
 */

use Symfony\Component\Dotenv\Dotenv;

$file = __DIR__ . '/.env';
if (file_exists($file)) {
  (new Dotenv())->load($file);
}
