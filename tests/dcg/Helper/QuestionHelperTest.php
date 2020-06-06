<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Helper\QuestionHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * A test for input handler.
 */
final class QuestionHelperTest extends TestCase {

  /**
   * Test callback.
   */
  public function testAsk(): void {

    // -- Question with default value.
    $output = $this->createOutput();
    $input = $this->createInput("\n");

    $question = new Question('What time is it?', '3:00');
    $answer = (new QuestionHelper())->ask($input, $output, $question);
    self::assertSame('3:00', $answer);

    $expected_display = "\n";
    $expected_display .= " What time is it? [3:00]:\n";
    $expected_display .= ' ➤ ';
    self::assertSame($expected_display, $this->getDisplay($output));

    // -- Question without default value.
    $output = $this->createOutput();
    $input = $this->createInput("4:00\n");

    $question = new Question('What time is it?');
    $answer = (new QuestionHelper())->ask($input, $output, $question);
    self::assertSame('4:00', $answer);

    $expected_display = "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= ' ➤ ';
    self::assertSame($expected_display, $this->getDisplay($output));

    // -- Question with validator.
    $output = $this->createOutput();
    $input = $this->createInput("4:00\n5:00\n");

    $question = new Question('What time is it?');
    $validator = static function (string $value): string {
      if ($value != '5:00') {
        throw new \UnexpectedValueException('The time is not correct!');
      }
      return $value;
    };
    $question->setValidator($validator);
    // Symfony\Component\Console\Helper\QuestionHelper::validateAttempts()
    // only allows one attempt when running without TTY.
    $question->setMaxAttempts(2);
    $answer = (new QuestionHelper())->ask($input, $output, $question);
    self::assertSame('5:00', $answer);

    $expected_display = "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= " ➤  The time is not correct!\n";
    $expected_display .= "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= ' ➤ ';
    self::assertSame($expected_display, $this->getDisplay($output));

    // -- Confirmation question.
    $output = $this->createOutput();
    $input = $this->createInput("\nYes\n");

    $question = new ConfirmationQuestion('Are you ready?');
    $answer = (new QuestionHelper())->ask($input, $output, $question);
    self::assertTrue($answer);

    $expected_display = "\n";
    $expected_display .= " Are you ready? [Yes]:\n";
    $expected_display .= ' ➤ ';
    self::assertSame($expected_display, $this->getDisplay($output));

    // -- Choice question.
    $output = $this->createOutput();
    $input = $this->createInput("5:00\n");

    $choices = [
      '3:00',
      '4:00',
      '5:00',
    ];
    $question = new ChoiceQuestion('What time is it?', $choices);
    $question->setAutocompleterValues(NULL);
    $answer = (new QuestionHelper())->ask($input, $output, $question);
    self::assertSame('5:00', $answer);

    $expected_display = "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= "  [0] 3:00\n";
    $expected_display .= "  [1] 4:00\n";
    $expected_display .= "  [2] 5:00\n";
    $expected_display .= "  ➤➤➤ ";
    self::assertSame($expected_display, $this->getDisplay($output));

    // -- Question answer option.
    $output = $this->createOutput();
    $input = $this->createInput('', ['5:00', NULL, '4:00']);

    $dialog = new QuestionHelper();
    $question = new Question('What time is it?');
    $answer = $dialog->ask($input, $output, $question);
    self::assertSame('5:00', $answer);

    $question = new Question('What time is it?', '3:00');
    $answer = $dialog->ask($input, $output, $question);
    self::assertSame('3:00', $answer);

    $question = new Question('What time is it?');
    $answer = $dialog->ask($input, $output, $question);
    self::assertSame('4:00', $answer);

    $expected_display = "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= " ➤ 5:00\n";
    $expected_display .= "\n";
    $expected_display .= " What time is it? [3:00]:\n";
    $expected_display .= " ➤ \n";
    $expected_display .= "\n";
    $expected_display .= " What time is it?\n";
    $expected_display .= " ➤ 4:00\n";
    self::assertSame($expected_display, $this->getDisplay($output));

  }

  /**
   * Creates input mock.
   */
  private function createInput(string $answers, ?array $answer_options = NULL): StreamableInputInterface {

    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $answers);
    \rewind($stream);

    $mock = $this->getMockBuilder(StreamableInputInterface::class)->getMock();
    $mock->expects($this->any())
      ->method('isInteractive')
      ->willReturn(TRUE);

    $mock->expects($this->any())
      ->method('getStream')
      ->willReturn($stream);

    $mock->expects($this->atLeast(1))
      ->method('hasOption')
      ->with('answer')
      ->willReturn(TRUE);

    $mock->expects($this->atLeast(1))
      ->method('getOption')
      ->with('answer')
      ->willReturn($answer_options);

    /** @var \Symfony\Component\Console\Input\StreamableInputInterface $mock */
    return $mock;
  }

  /**
   * Creates stream output.
   */
  private function createOutput(): StreamOutput {
    return new StreamOutput(\fopen('php://memory', 'r+', FALSE));
  }

  /**
   * Returns output display.
   */
  private function getDisplay(StreamOutput $output): string {
    \rewind($output->getStream());
    return \stream_get_contents($output->getStream());
  }

}
