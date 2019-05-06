<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * Defines console logger factory.
 */
class LoggerFactory extends Helper implements IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'logger_factory';
  }

  /**
   * Creates logger instance.
   *
   * @return \Psr\Log\LoggerInterface
   *   Console logger.
   */
  public function getLogger() :LoggerInterface {
    if (!$this->logger) {
      $this->logger = new ConsoleLogger($this->io);
    }
    return $this->logger;
  }

}
