<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Exception;

/**
 * The exception interface for DCG generators.
 *
 * Use this exception for errors caused by wrong user input or when environment
 * does not meet certain requirements. Do not use it for unexpected program
 * errors.
 */
interface ExceptionInterface extends \Throwable {

}
