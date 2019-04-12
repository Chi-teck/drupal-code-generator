<?php

/**
 * @file
 * Loads environment variables from .env files.
 *
 * This file is included very early.
 * @see composer.json For autoload section.
 */

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

$dotenv = Dotenv::create(__DIR__);
try {
  $dotenv->load();
}
catch (InvalidPathException $exception) {
  // Do nothing. The environment may have no any .env files.
}
