<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper;

use DrupalCodeGenerator\Helper\QuestionHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * A test for input handler.
 */
final class QuestionHelperTest extends TestCase {

  /**
   * Console input.
   */
  private ArrayInput $input;

  /**
   * Console output.
   */
  private BufferedOutput $output;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $definition[] = new InputOption('answer', 'a', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL);
    $this->input = new ArrayInput([], new InputDefinition($definition));
    $this->output = new BufferedOutput();
  }

  /**
   * Test callback.
   */
  public function testQuestionWithDefaultValue(): void {
    $this->setStream("\n");

    $answer = $this->ask(new Question('What time is it?', '3:00'));
    self::assertSame('3:00', $answer);

    $expected_display = <<< 'TXT'

       What time is it? [3:00]:
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   */
  public function testQuestionWithoutDefaultValue(): void {
    $this->setStream("4:00\n");

    $answer = $this->ask(new Question('What time is it?'));
    self::assertSame('4:00', $answer);

    $expected_display = <<< 'TXT'

       What time is it?
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   */
  public function testQuestionValidator(): void {
    $this->setStream("4:00\n5:00\n");

    $question = new Question('What time is it?');
    $validator = static function (string $value): string {
      if ($value !== '5:00') {
        throw new \UnexpectedValueException('The time is not correct!');
      }
      return $value;
    };
    $question->setValidator($validator);
    // Symfony\Component\Console\Helper\QuestionHelper::validateAttempts()
    // only allows one attempt when running without TTY.
    $question->setMaxAttempts(2);
    $answer = $this->ask($question);
    self::assertSame('5:00', $answer);

    // The error message does not show up on a new line because user input is
    // not reflected in the trapped output.
    $expected_display = <<< 'TXT'
      
       What time is it?
       ➤  The time is not correct!

       What time is it?
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   */
  public function testQuestionSuffix(): void {
    $this->setStream("\n");
    $this->ask(new Question('test?'));
    $this->assertOutput("\n test?\n ➤ ");

    $this->setStream("\n");
    $this->ask(new Question('test'));
    $this->assertOutput("\n test:\n ➤ ");
  }

  /**
   * Test callback.
   */
  public function testConfirmationQuestionWithDefaultValueYes(): void {
    $this->setStream("\n");

    $question = new ConfirmationQuestion('Are you ready?', TRUE);
    $answer = $this->ask($question);
    self::assertTrue($answer);

    $expected_display = <<< 'TXT'

       Are you ready? [Yes]:
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   */
  public function testConfirmationQuestionWithDefaultValueNo(): void {
    $this->setStream("\n");

    $question = new ConfirmationQuestion('Are you ready?', FALSE);
    $answer = $this->ask($question);
    self::assertFalse($answer);

    $expected_display = <<< 'TXT'

       Are you ready? [No]:
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   *
   * @todo Remove this as it actually tests default question helper.
   */
  #[DataProvider('confirmationQuestionProvider')]
  public function testConfirmationQuestionAnswers(string $input, bool $expected_answer): void {
    $this->setStream("$input\n");

    $question = new ConfirmationQuestion('Are you ready?');
    $answer = $this->ask($question);
    self::assertSame($expected_answer, $answer);
  }

  /**
   * Data provider for testConfirmationQuestionAnswers().
   */
  public static function confirmationQuestionProvider(): array {
    return [
      ['Yes', TRUE],
      ['yes', TRUE],
      ['YeS', TRUE],
      ['yo', TRUE],
      ['', TRUE],
      ['No', FALSE],
      ['---', FALSE],
      ['%&^*(%', FALSE],
    ];
  }

  /**
   * Test callback.
   */
  public function testChoiceQuestion(): void {
    $this->setStream("5:00\n");

    $choices = [
      '3:00',
      '4:00',
      '5:00',
    ];
    $question = new ChoiceQuestion('What time is it?', $choices);
    $answer = $this->ask($question);
    self::assertSame('5:00', $answer);

    $expected_display = <<< 'TXT'

       What time is it?
        [0] 3:00
        [1] 4:00
        [2] 5:00
       ➤ 
      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Test callback.
   *
   * @todo test validation.
   * @todo test trimming.
   * @todo test normalizer.
   */
  public function testAnswerOption(): void {
    // This matches the following command `dcg <generator> -a 5:00 -a -a 4:00`.
    $this->input->setOption('answer', ['5:00', NULL, '4:00']);

    $question_helper = new QuestionHelper();

    // Answer from the option.
    $question = new Question('What time is it?');
    $answer = $question_helper->ask($this->input, $this->output, $question);
    self::assertSame('5:00', $answer);

    // Answer from the default value as the option value is set to NULL.
    $question = new Question('What time is it?', '3:00');
    $answer = $question_helper->ask($this->input, $this->output, $question);
    self::assertSame('3:00', $answer);

    // Answer from the option.
    $question = new Question('What time is it?');
    $answer = $question_helper->ask($this->input, $this->output, $question);
    self::assertSame('4:00', $answer);

    $expected_display = <<< 'TXT'

       What time is it?
       ➤ 5:00

       What time is it? [3:00]:
       ➤ 

       What time is it?
       ➤ 4:00

      TXT;
    $this->assertOutput($expected_display);
  }

  /**
   * Asks a question.
   */
  private function ask(Question $question): NULL|bool|string {
    return (new QuestionHelper())->ask($this->input, $this->output, $question);
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   */
  private function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Asserts output.
   */
  private function assertOutput(string $expected_output): void {
    self::assertSame($expected_output, $this->output->fetch());
  }

}
