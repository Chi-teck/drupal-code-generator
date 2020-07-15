<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Command\GeneratorInterface;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Utils;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Question\Question;

/**
 * A test for input handler.
 */
class InputHandlerTest extends TestCase {

  /**
   * Input handler to test.
   *
   * @var \DrupalCodeGenerator\Helper\InputHandler
   */
  protected $handler;

  /**
   * The input.
   *
   * @var \Symfony\Component\Console\Input\ArrayInput
   */
  protected $input;

  /**
   * The output.
   *
   * @var \Symfony\Component\Console\Output\BufferedOutput
   */
  protected $output;

  /**
   * {@inheritdoc}
   */
  public function __construct($name = NULL, array $data = [], $dataName = '') {
    parent::__construct($name, $data, $dataName);

    $input_definition = new InputDefinition(
      [new InputOption('answers')]
    );
    $this->input = new ArrayInput([], $input_definition);

    $command = $this->createMock(GeneratorInterface::class);
    $command->method('getDirectory')
      ->willReturn('directory_name');

    $helper_set = $this->createMock(HelperSet::class);
    $helper_set->method('getCommand')
      ->willReturn($command);

    $question_helper = new QuestionHelper();

    $helper_set->method('get')
      ->willReturn($question_helper);

    $this->handler = new InputHandler();
    $this->handler->setHelperSet($helper_set);

    $this->output = new BufferedOutput();
  }

  /**
   * Test callback.
   */
  public function testHelperName() {
    static::assertEquals($this->handler->getName(), 'dcg_input_handler');
  }

  /**
   * Test callback.
   *
   * @dataProvider inputTestProvider()
   */
  public function testInputHandler($questions, $input_raw, $expected_vars, $output_raw) {
    $output_raw = is_array($output_raw) ? implode("\n", $output_raw) : $output_raw;

    $this->input->setStream($this->getInputStream($input_raw));

    $vars = $this->handler->collectVars($this->input, $this->output, $questions);

    $output_raw = is_array($output_raw) ? implode("\n", $output_raw) : $output_raw;

    static::assertEquals($this->output->fetch(), $output_raw);
    static::assertEquals($expected_vars, $vars);
  }

  /**
   * Test callback.
   */
  public function testAnswerOption() {

    $this->input->setStream($this->getInputStream("Zoo\n"));
    $this->input->setOption('answers', '{"name":"Bar"}');

    $questions['name'] = new Question('Name', 'Default name');
    $questions['machine_name'] = new Question('Machine name', 'Default machine name');

    $vars = $this->handler->collectVars($this->input, $this->output, $questions);
    $expected_vars = [
      'name' => 'Bar',
      'machine_name' => 'Default machine name',
    ];
    static::assertEquals($expected_vars, $vars);
    static::assertEquals('', $this->output->fetch());

    $this->input->setOption('answers', 'Wrong JSON');
    $this->expectException('Symfony\Component\Console\Exception\InvalidOptionException');
    $this->handler->collectVars($this->input, $this->output, []);
  }

  /**
   * Data provider callback for testDefaultPluginId().
   */
  public function inputTestProvider() {
    $data = [];

    // Default case.
    $row = [];
    $row[] = [
      'name' => new Question('Name', 'Example'),
      'machine_name' => new Question('Machine name', 'example'),
    ];
    $row[] = "Example\nexample\nbar";
    $row[] = [
      'name' => 'Example',
      'machine_name' => 'example',
    ];
    $row[] = "\n Name [Example]:\n ➤ \n Machine name [example]:\n ➤ ";
    $data[] = $row;
    // Without default values.
    $row = [];
    $row[] = [
      'name' => new Question('Name'),
      'machine_name' => new Question('Machine name'),
      'plugin_label' => new Question('Plugin label'),
      'plugin_id' => new Question('Plugin ID'),
    ];
    $row[] = "Example\nexample\nBar\nbar";
    $row[] = [
      'name' => 'Example',
      'machine_name' => 'example',
      'plugin_label' => 'Bar',
      'plugin_id' => 'bar',
    ];
    $row[] = "\n Name [Directory name]:\n ➤ \n Machine name [example]:\n ➤ \n Plugin label:\n ➤ \n Plugin ID:\n ➤ ";
    $data[] = $row;

    // Test default validators.
    $row = [];

    $questions = [];
    $questions['machine_name'] = new Question('Machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $questions['machine_name']->setMaxAttempts(2);
    $questions['class'] = new Question('Class');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);
    $questions['class']->setMaxAttempts(2);
    $questions['foo'] = new Question('Foo');
    $questions['foo']->setValidator([Utils::class, 'validateRequired']);
    $questions['foo']->setMaxAttempts(2);

    $row[] = $questions;
    $row[] = "%wrong%\nexample\nb%ar\nBar\n\nexample";
    $row[] = [
      'machine_name' => 'example',
      'class' => 'Bar',
      'foo' => 'example',
    ];
    $row[] = [
      "\n Machine name [directory_name]:\n ➤ The value is not correct machine name.",
      "\n Machine name [directory_name]:\n ➤ \n Class:\n ➤ The value is not correct class name.",
      "\n Class:\n ➤ \n Foo:\n ➤ The value is required.",
      "\n Foo:\n ➤ ",
    ];
    $data[] = $row;

    // Test default value callback.
    $row = [];
    $callable = function ($vars) {
      return '*' . $vars['name'] . '*';
    };
    $row[] = [
      'name' => new Question('Name', 'Zoo'),
      'bar' => new Question('bar', $callable),
    ];
    $row[] = "example\nexample";
    $row[] = [
      'name' => 'example',
      'bar' => 'example',
    ];
    $row[] = "\n Name [Zoo]:\n ➤ \n bar [*example*]:\n ➤ ";
    $data[] = $row;

    return $data;
  }

  /**
   * Returns input stream.
   */
  protected function getInputStream($input) {
    $stream = fopen('php://memory', 'r+', FALSE);
    fwrite($stream, $input);
    rewind($stream);
    return $stream;
  }

}
