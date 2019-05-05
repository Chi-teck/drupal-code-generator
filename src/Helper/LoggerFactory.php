<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\Logger;
use DrupalCodeGenerator\OutputAwareInterface;
use DrupalCodeGenerator\OutputAwareTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * Defines console logger factory.
 */
class LoggerFactory extends Helper implements OutputAwareInterface, LoggerAwareInterface {

  use OutputAwareTrait;
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
      $this->logger = new Logger($this->output);
    }
    return $this->logger;
  }

}
