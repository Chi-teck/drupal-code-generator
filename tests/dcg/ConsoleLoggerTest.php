<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Logger\ConsoleLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A test for console logger.
 */
final class ConsoleLoggerTest extends TestCase {

  /**
   * Test callback.
   */
  public function testLogger(): void {

    $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, TRUE);
    $logger = new ConsoleLogger($output);

    $logger->emergency('Example');
    self::assertSame("[\e[31;1memergency\e[39;22m] Example\n", $output->fetch());

    $logger->alert('Example');
    self::assertSame("[\e[31;1malert\e[39;22m] Example\n", $output->fetch());

    $logger->critical('Example');
    self::assertSame("[\e[31;1mcritical\e[39;22m] Example\n", $output->fetch());

    $logger->error('Example');
    self::assertSame("[\e[31;1merror\e[39;22m] Example\n", $output->fetch());

    $logger->warning('Example');
    self::assertSame("[\e[33;1mwarning\e[39;22m] Example\n", $output->fetch());

    $logger->notice('Example');
    self::assertSame('', $output->fetch());

    $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
    $logger->notice('Example');
    self::assertSame("[\e[32;1mnotice\e[39;22m] Example\n", $output->fetch());

    $logger->info('Example');
    self::assertSame('', $output->fetch());

    $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
    $logger->info('Example');
    self::assertSame("[\e[32;1minfo\e[39;22m] Example\n", $output->fetch());

    $logger->debug('Example');
    self::assertSame('', $output->fetch());

    $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
    $logger->debug('Example');
    self::assertSame("[\e[36;1mdebug\e[39;22m] Example\n", $output->fetch());

    $logger->log(LogLevel::DEBUG, 'Foo: {foo}.', ['foo' => 'bar']);
    self::assertSame("[\e[36;1mdebug\e[39;22m] Foo: bar.\n", $output->fetch());

    $this->expectException(InvalidArgumentException::class);
    $logger->log('Unknown level', 'Example');
  }

}
