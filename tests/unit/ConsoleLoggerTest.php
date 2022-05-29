<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit;

use DrupalCodeGenerator\Logger\ConsoleLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel as LL;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface as OI;

/**
 * A test for console logger.
 */
final class ConsoleLoggerTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider outputMappingProvider()
   */
  public function testOutputMapping(string $log_level, int $verbosity, string $expected_output): void {
    $output = new BufferedOutput($verbosity, TRUE);
    $logger = new ConsoleLogger($output);
    $logger->log($log_level, 'Example');
    self::assertSame($expected_output, $output->fetch());
  }

  /**
   * Data provider for testOutputMapping().
   */
  public static function outputMappingProvider(): array {
    $mapping = [
      [
        LL::EMERGENCY,
        OI::VERBOSITY_NORMAL,
        '[<fg=red;options=bold;>emergency</>] Example',
      ],
      [
        LL::ALERT,
        OI::VERBOSITY_NORMAL,
        '[<fg=red;options=bold;>alert</>] Example',
      ],
      [
        LL::CRITICAL,
        OI::VERBOSITY_NORMAL,
        '[<fg=red;options=bold;>critical</>] Example',
      ],
      [
        LL::WARNING,
        OI::VERBOSITY_NORMAL,
        '[<fg=yellow;options=bold;>warning</>] Example',
      ],
      [LL::NOTICE, OI::VERBOSITY_NORMAL, ''],
      [LL::INFO, OI::VERBOSITY_NORMAL, ''],
      [LL::DEBUG, OI::VERBOSITY_NORMAL, ''],

      [
        LL::EMERGENCY,
        OI::VERBOSITY_VERBOSE,
        '[<fg=red;options=bold;>emergency</>] Example',
      ],
      [
        LL::ALERT,
        OI::VERBOSITY_VERBOSE,
        '[<fg=red;options=bold;>alert</>] Example',
      ],
      [
        LL::CRITICAL,
        OI::VERBOSITY_VERBOSE,
        '[<fg=red;options=bold;>critical</>] Example',
      ],
      [
        LL::WARNING,
        OI::VERBOSITY_VERBOSE,
        '[<fg=yellow;options=bold;>warning</>] Example',
      ],
      [
        LL::NOTICE,
        OI::VERBOSITY_VERBOSE,
        '[<fg=green;options=bold;>notice</>] Example',
      ],
      [LL::INFO, OI::VERBOSITY_VERBOSE, ''],
      [LL::DEBUG, OI::VERBOSITY_VERBOSE, ''],

      [
        LL::EMERGENCY,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=red;options=bold;>emergency</>] Example',
      ],
      [
        LL::ALERT,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=red;options=bold;>alert</>] Example',
      ],
      [
        LL::CRITICAL,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=red;options=bold;>critical</>] Example',
      ],
      [
        LL::WARNING,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=yellow;options=bold;>warning</>] Example',
      ],
      [
        LL::NOTICE,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=green;options=bold;>notice</>] Example',
      ],
      [
        LL::INFO,
        OI::VERBOSITY_VERY_VERBOSE,
        '[<fg=green;options=bold;>info</>] Example',
      ],
      [LL::DEBUG, OI::VERBOSITY_VERY_VERBOSE, ''],

      [
        LL::EMERGENCY,
        OI::VERBOSITY_DEBUG,
        '[<fg=red;options=bold;>emergency</>] Example',
      ],
      [
        LL::ALERT,
        OI::VERBOSITY_DEBUG,
        '[<fg=red;options=bold;>alert</>] Example',
      ],
      [
        LL::CRITICAL,
        OI::VERBOSITY_DEBUG,
        '[<fg=red;options=bold;>critical</>] Example',
      ],
      [
        LL::WARNING,
        OI::VERBOSITY_DEBUG,
        '[<fg=yellow;options=bold;>warning</>] Example',
      ],
      [
        LL::NOTICE,
        OI::VERBOSITY_DEBUG,
        '[<fg=green;options=bold;>notice</>] Example',
      ],
      [
        LL::INFO,
        OI::VERBOSITY_DEBUG,
        '[<fg=green;options=bold;>info</>] Example',
      ],
      [
        LL::DEBUG,
        OI::VERBOSITY_DEBUG,
        '[<fg=cyan;options=bold;>debug</>] Example',
      ],
    ];

    // Render expected output.
    \array_walk(
      $mapping,
      static function (&$row): void {
        if ($row[2]) {
          $output = new BufferedOutput($row[1], TRUE);
          $output->writeln($row[2]);
          $row[2] = $output->fetch();
        }
      },
    );

    return $mapping;
  }

  /**
   * Test callback.
   */
  public function testThrowsOnWrongLogLevel(): void {
    $logger = new ConsoleLogger(new BufferedOutput(OI::VERBOSITY_NORMAL, TRUE));
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('The log level "Unknown level" does not exist.');
    $logger->log('Unknown level', 'Example');
  }

  /**
   * Test callback.
   */
  public function testInterpolation(): void {
    $output = new BufferedOutput(OI::VERBOSITY_NORMAL, FALSE);
    $logger = new ConsoleLogger($output);

    $message = <<< 'EOT'

            Value 1: {v1}
            Value 2: {v2}
            Value 3: {v3}
            Value 4: {v4}
            Value 5: {v5}
        EOT;
    $context = [
      'v1' => 'Example',
      'v2' => new \DateTime('2000-01-01T00:00:00+00:00'),
      'v3' => new \stdClass(),

      'v4' => new class {
        // phpcs:ignore Drupal.Commenting.FunctionComment.Missing
        public function __toString(): string {
          return 'This is foo object.';
        }

      },
      'v5' => [],
    ];
    $logger->log(LL::WARNING, $message, $context);

    $expected_output = <<< 'EOT'
        [warning] 
            Value 1: Example
            Value 2: 2000-01-01T00:00:00+00:00
            Value 3: [object stdClass]
            Value 4: This is foo object.
            Value 5: [array]

        EOT;
    self::assertSame($expected_output, $output->fetch());
  }

}
