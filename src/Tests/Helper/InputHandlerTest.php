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
    $this->assertEquals($this->handler->getName(), 'dcg_input_handler');
  }

  /**
   * Test callback.
   *
   * @covers InputHandler::collectVars()
   * @dataProvider inputTestProvider()
   */
  public function testInputHandler($questions, $input_raw, $expected_vars, $output_raw) {

    $output_raw = is_array($output_raw) ? implode("\n", $output_raw) : $output_raw;

    $this->input->setStream($this->getInputStream($input_raw));

    $vars = $this->handler->collectVars($this->input, $this->output, $questions);

    $this->assertEquals($this->output->fetch(), $output_raw);

    $this->assertEquals($expected_vars, $vars);
  }

  /**
   * Data provider callback for testDefaultPluginId().
   */
  public function inputTestProvider() {
    $data = [];

    // Default case.
    $row = [];
    $row[] = [
      'name' => ['Name', 'Example'],
      'machine_name' => ['Machine name', 'example'],
      'plugin_id' => ['Plugin ID', 'foo'],
    ];
    $row[] = "Example\nexample\nbar";
    $row[] = [
      'name' => 'Example',
      'machine_name' => 'example',
      'plugin_id' => 'bar',
    ];
    $row[] = 'Name [Example]: Machine name [example]: Plugin ID [foo]: ';
    $data[] = $row;

    // Without default values.
    $row = [];
    $row[] = [
      'name' => ['Name'],
      'machine_name' => ['Machine name'],
      'plugin_label' => ['Plugin label'],
      'plugin_id' => ['Plugin ID'],
    ];
    $row[] = "Example\nexample\nBar\nbar";
    $row[] = [
      'name' => 'Example',
      'machine_name' => 'example',
      'plugin_label' => 'Bar',
      'plugin_id' => 'bar',
    ];
    $row[] = 'Name [Directory name]: Machine name [example]: Plugin label: Plugin ID [example_bar]: ';
    $data[] = $row;

    // Test default validators.
    $row = [];
    $row[] = [
      // Machine name validator.
      'machine_name' => [
        'Machine name',
        NULL,
        [Utils::class, 'validateMachineName'],
      ],
      // Class validator.
      'class' => ['Class', NULL, [Utils::class, 'validateClassName']],
      // Required value validator.
      'foo' => ['Foo'],
    ];
    $row[] = "%wrong%\nexample\nb%ar\nBar\n\nexample";
    $row[] = [
      'machine_name' => 'example',
      'class' => 'Bar',
      'foo' => 'example',
    ];
    $row[] = [
      'Machine name [directory_name]: The value is not correct machine name.',
      'Machine name [directory_name]: Class: The value is not correct class name.',
      'Class: Foo: The value is required.',
      'Foo: ',
    ];
    $data[] = $row;

    // Test default value callback.
    $row = [];
    $callable = function ($vars) {
      return '*' . $vars['name'] . '*';
    };
    $row[] = [
      'name' => ['Name', 'Zoo'],
      'bar' => ['bar', $callable],
    ];
    $row[] = "example\nexample";
    $row[] = [
      'name' => 'example',
      'bar' => 'example',
    ];
    $row[] = 'Name [Zoo]: bar [*example*]: ';
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
