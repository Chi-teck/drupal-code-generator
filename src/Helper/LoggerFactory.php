<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * Defines console logger factory.
 */
class LoggerFactory extends Helper implements LoggerAwareInterface {

  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'logger_factory';
  }

  /**
   * Creates logger instance.
   */
  public function getLogger(GeneratorStyleInterface $io): LoggerInterface {
    if (!$this->logger) {
      $this->logger = new ConsoleLogger($io);
    }
    return $this->logger;
  }

}
