<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit;

use DrupalCodeGenerator\Command\GenerateCompletion;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Tests completion generator.
 */
final class GenerateCompletionTest extends TestCase {

  /**
   * Test callback.
   */
  public function testDefinition(): void {
    $command = new GenerateCompletion();
    self::assertSame('generate-completion', $command->getName());
    self::assertSame('Generates shell completion for DCG', $command->getDescription());
    self::assertSame(['generate-completion --shell=bash >> ~/.bash_completion'], $command->getUsages());
  }

  /**
   * Test callback.
   *
   * @dataProvider outputProvider()
   */
  public function testOutput(string $prefix, string $inner, string $suffix, ?string $shell = NULL): void {
    $parameters = $shell ? ['--shell' => $shell] : [];
    $input = new ArrayInput($parameters);
    $output = new BufferedOutput();
    $command = new GenerateCompletion();

    $result = $command->run($input, $output);
    self::assertSame(Command::SUCCESS, $result);

    $display = $output->fetch();

    self::assertStringStartsWith($prefix, $display);
    self::assertStringContainsString($inner, $display);
    self::assertStringEndsWith($suffix, $display);
  }

  /**
   * Data provider callback for testCompletionGenerator().
   */
  public function outputProvider(): array {
    return [
      ["_dcg()\n", 'render-element)', "complete -o default -F _dcg dcg\n\n", NULL],
      ["_dcg()\n", 'render-element)', "complete -o default -F _dcg dcg\n\n", 'bash'],
      ["function __fish_dcg_no_subcommand\n", ' render-element ', "# yml:theme-libraries\n\n", 'fish'],
      ["#compdef dcg\n", 'render-element)', "compdef _dcg dcg\n\n", 'zsh'],
    ];
  }

  /**
   * Test callback.
   */
  public function testErrorHandler(): void {
    $parameters = ['--shell' => 'csh'];
    $input = new ArrayInput($parameters);
    $error_output = new BufferedOutput();
    $output = new class ($error_output) extends BufferedOutput {

      public function __construct(private readonly BufferedOutput $errorOutput) {
        parent::__construct();
      }

      public function getErrorOutput(): BufferedOutput {
        return $this->errorOutput;
      }

    };
    $command = new GenerateCompletion();

    $result = $command->run($input, $output);
    self::assertSame(Command::FAILURE, $result);

    self::assertSame('', $output->fetch());
    self::assertSame("Shell \"csh\" is not supported.\n", $error_output->fetch());
  }

}
