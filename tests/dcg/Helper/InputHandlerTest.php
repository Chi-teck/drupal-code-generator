<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Command\GeneratorInterface;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Tests\QuestionHelper;
use DrupalCodeGenerator\Utils;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
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

    $this->input = new ArrayInput([], new InputDefinition());
    $this->output = new BufferedOutput();

    $command = $this->createMock(GeneratorInterface::class);
    $command->method('getDirectory')
      ->willReturn('directory_name');

    $helper_set = $this->createMock(HelperSet::class);
    $helper_set->method('getCommand')
      ->willReturn($command);

    $question_helper = new QuestionHelper();
    $io = new GeneratorStyle($this->input, $this->output, $question_helper);

    $value_map = [
      ['question', $question_helper],
    ];

    $helper_set->expects($this->any())
      ->method('get')
      ->will($this->returnValueMap($value_map));

    $this->handler = new InputHandler();
    $this->handler->io($io);
    $this->handler->setHelperSet($helper_set);
    $question_helper->setHelperSet($helper_set);
  }

  /**
   * Test callback.
   */
  public function testHelperName() {
    static::assertEquals($this->handler->getName(), 'input_handler');
  }

  /**
   * Test callback.
   *
   * @dataProvider inputTestProvider()
   */
  public function testInputHandler($questions, $input_raw, $expected_vars, $output_raw) {
    $output_raw = is_array($output_raw) ? implode("\n", $output_raw) : $output_raw;

    $this->input->setStream($this->getInputStream($input_raw));

    $vars = $this->handler->collectVars($questions);

    $output_raw = is_array($output_raw) ? implode("\n", $output_raw) : $output_raw;

    static::assertEquals($this->output->fetch(), $output_raw);
    static::assertEquals($expected_vars, $vars);
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
    $row[] = "\n Name [Example]:\n ➤ \n\n Machine name [example]:\n ➤ \n";
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
    $row[] = "\n Name [Directory name]:\n ➤ \n\n Machine name [example]:\n ➤ \n\n Plugin label:\n ➤ \n\n Plugin ID:\n ➤ \n";
    $data[] = $row;

    // Test default validators.
    $row = [];
    $questions = [];
    $questions['machine_name'] = new Question('Machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $questions['class'] = new Question('Class');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);
    $questions['foo'] = new Question('Foo');
    $questions['foo']->setValidator([Utils::class, 'validateRequired']);

    $row[] = $questions;
    $row[] = "%wrong%\nexample\nb%ar\nBar\n\nexample";
    $row[] = [
      'machine_name' => 'example',
      'class' => 'Bar',
      'foo' => 'example',
    ];
    $row[] = [
      "\n Machine name [directory_name]:\n ➤ The value is not correct machine name.",
      "\n Machine name [directory_name]:\n ➤ \n\n Class:\n ➤ The value is not correct class name.",
      "\n Class:\n ➤ \n\n Foo:\n ➤ The value is required.",
      "\n Foo:\n ➤ \n",
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
    $row[] = "\n Name [Zoo]:\n ➤ \n\n bar [*example*]:\n ➤ \n";
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
