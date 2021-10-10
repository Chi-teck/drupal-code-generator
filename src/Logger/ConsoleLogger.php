<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * PSR-3 compliant console logger.
 */
class ConsoleLogger extends AbstractLogger {

  /**
   * Console output.
   */
  protected OutputInterface $output;

  /**
   * Verbosity level map.
   *
   * @var array
   */
  private array $verbosityLevelMap = [
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
  public function __construct(OutputInterface $output) {
    $this->output = $output;
  }

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []): void {

    if (!isset($this->verbosityLevelMap[$level])) {
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
    if ($output->getVerbosity() >= $this->verbosityLevelMap[$level]) {

      switch ($level) {
        case LogLevel::EMERGENCY;
        case LogLevel::ALERT;
        case LogLevel::CRITICAL;
        case LogLevel::ERROR;
          $label = "<fg=red;options=bold;>$level</>";
          break;

        case LogLevel::WARNING;
          $label = "<fg=yellow;options=bold;>$level</>";
          break;

        case LogLevel::NOTICE;
        case LogLevel::INFO;
          $label = "<fg=green;options=bold;>$level</>";
          break;

        case LogLevel::DEBUG;
          $label = "<fg=cyan;options=bold;>$level</>";
          break;
      }

      $formatted_message = \sprintf('[%s] %s', $label, $this->interpolate($message, $context));
      $output->writeln($formatted_message, $this->verbosityLevelMap[$level]);
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
      if ($value === NULL || \is_scalar($value) || (\is_object($value) && \method_exists($value, '__toString'))) {
        $replacements["{{$key}}"] = $value;
      }
      elseif ($value instanceof \DateTimeInterface) {
        $replacements["{{$key}}"] = $value->format(\DateTime::RFC3339);
      }
      elseif (\is_object($value)) {
        $replacements["{{$key}}"] = '[object ' . \get_class($value) . ']';
      }
      else {
        $replacements["{{$key}}"] = '[' . \gettype($value) . ']';
      }
    }

    return \strtr($message, $replacements);
  }

}
