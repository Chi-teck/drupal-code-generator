<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * PSR-3 compliant console logger.
 */
final class ConsoleLogger extends AbstractLogger {

  /**
   * Verbosity level map.
   */
  private const VERBOSITY_LEVEL_MAP = [
    LogLevel::EMERGENCY => OutputInterface::VERBOSITY_NORMAL,
    LogLevel::ALERT => OutputInterface::VERBOSITY_NORMAL,
    LogLevel::CRITICAL => OutputInterface::VERBOSITY_NORMAL,
    LogLevel::ERROR => OutputInterface::VERBOSITY_NORMAL,
    LogLevel::WARNING => OutputInterface::VERBOSITY_NORMAL,
    LogLevel::NOTICE => OutputInterface::VERBOSITY_VERBOSE,
    LogLevel::INFO => OutputInterface::VERBOSITY_VERY_VERBOSE,
    LogLevel::DEBUG => OutputInterface::VERBOSITY_DEBUG,
  ];

  /**
   * Logger constructor.
   */
  public function __construct(private readonly OutputInterface $output) {}

  /**
   * {@inheritdoc}
   */
  public function log($level, string|\Stringable $message, array $context = []): void {

    if (!isset(self::VERBOSITY_LEVEL_MAP[$level])) {
      throw new InvalidArgumentException("The log level \"$level\" does not exist.");
    }

    $output = $this->output;

    // Write to the error output if necessary and available.
    $error_levels = [
      LogLevel::EMERGENCY,
      LogLevel::ALERT,
      LogLevel::CRITICAL,
      LogLevel::ERROR,
    ];
    if (\in_array($level, $error_levels)) {
      if ($output instanceof ConsoleOutputInterface) {
        /** @var \Symfony\Component\Console\Output\ConsoleOutputInterface $output */
        $output = $output->getErrorOutput();
      }
    }

    // The if condition check isn't necessary -- it's the same one that $output
    // will do internally anyway. We only do it for efficiency here as the
    // message formatting is relatively expensive.
    if ($output->getVerbosity() >= self::VERBOSITY_LEVEL_MAP[$level]) {
      /** @psalm-suppress UnhandledMatchCondition */
      $label = match ($level) {
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR => "<fg=red;options=bold;>$level</>",
        LogLevel::WARNING => "<fg=yellow;options=bold;>$level</>",
        LogLevel::NOTICE,
        LogLevel::INFO => "<fg=green;options=bold;>$level</>",
        LogLevel::DEBUG => "<fg=cyan;options=bold;>$level</>",
      };

      $formatted_message = \sprintf(
        '[%s] %s', $label, $this->interpolate((string) $message, $context),
      );
      $output->writeln($formatted_message, self::VERBOSITY_LEVEL_MAP[$level]);
    }
  }

  /**
   * Interpolates context values into the message placeholders.
   *
   * @see \Symfony\Component\Console\Logger::interpolate()
   */
  private function interpolate(string $message, array $context): string {
    if (!\str_contains($message, '{')) {
      return $message;
    }

    $replacements = [];
    foreach ($context as $key => $value) {
      $replacements["{{$key}}"] = match(TRUE) {
        $value === NULL || \is_scalar($value) || (\is_object($value) && \method_exists($value, '__toString')) => $value,
        $value instanceof \DateTimeInterface => $value->format(\DateTimeInterface::RFC3339),
        \is_object($value) => '[object ' . $value::class . ']',
        default => '[' . \get_debug_type($value) . ']'
      };
    }

    return \strtr($message, $replacements);
  }

}
