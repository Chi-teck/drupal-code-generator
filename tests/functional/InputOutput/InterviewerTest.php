<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\InputOutput;

use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Helper\Drupal\NullExtensionInfo;
use DrupalCodeGenerator\Helper\Drupal\PermissionInfo;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Helper\Drupal\ThemeInfo;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\Interviewer;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputOption as Option;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Tests interviewer.
 */
final class InterviewerTest extends FunctionalTestBase {

  private IO $io;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $definition[] = new InputOption('working-dir', 'd', Option::VALUE_OPTIONAL, 'Working directory');
    $this->io = new IO(
      new ArrayInput([], new InputDefinition($definition)),
      new BufferedOutput(),
      new QuestionHelper(),
    );
  }

  /**
   * Test callback.
   */
  public function testAsk(): void {
    $vars = [
      'foo' => 123,
      'bar' => 456,
    ];
    $interviewer = $this->createInterviewer($vars);

    $this->setStream('example');
    $answer = $interviewer->ask('-={foo}=-', '-={bar}=-');
    self::assertSame('example', $answer);
    $expected_output = <<< 'TXT'

       -=123=- [-=456=-]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testConfirm(): void {
    $interviewer = $this->createInterviewer(['foo' => 123]);

    $this->setStream('No');
    $answer = $interviewer->confirm('-={foo}=-');
    self::assertFalse($answer);
    $expected_output = <<< 'TXT'

       -=123=- [Yes]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testChoice(): void {
    $interviewer = $this->createInterviewer(['foo' => 123]);

    $this->setStream('Beta');
    $choices = [
      'alpha' => 'Alpha',
      'beta' => 'Beta',
      'gamma' => 'Gamma',
    ];
    $answer = $interviewer->choice('-={foo}=-', $choices);
    self::assertSame('beta', $answer);
    $expected_output = <<< 'TXT'

       -=123=-:
        [1] Alpha
        [2] Beta
        [3] Gamma
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   *
   * @dataProvider askNameProvider()
   */
  public function testAskName(GeneratorType $type, ?string $machine_name, string $expected_answer, string $expected_output): void {
    $definition = new GeneratorDefinition('test', type: $type);
    $vars = $machine_name ? ['machine_name' => $machine_name] : [];
    $interviewer = $this->createInterviewer($vars, $definition);

    $this->setStream('Example');
    $answer = $interviewer->askName();
    self::assertSame($expected_answer, $answer);

    $format_output = static fn (string $output): string =>
      $output ? "\n $expected_output:\n ➤ " : '';
    $this->assertOutput($format_output($expected_output));
  }

  /**
   * Data provider for testAskName.
   *
   * @dataProvider
   */
  public function askNameProvider(): array {
    return [
      [GeneratorType::MODULE, 'dblog', 'Example', 'Module name [Dblog]'],
      [GeneratorType::MODULE_COMPONENT, 'dblog', 'Database Logging', ''],
      [GeneratorType::MODULE_COMPONENT, 'missing', 'Example', 'Module name [Missing]'],
      [GeneratorType::MODULE_COMPONENT, NULL, 'Example', 'Module name'],
      [GeneratorType::THEME, NULL, 'Example', 'Theme name'],
      [GeneratorType::THEME_COMPONENT, 'olivero', 'Olivero', ''],
      [GeneratorType::THEME_COMPONENT, 'missing', 'Example', 'Theme name [Missing]'],
      [GeneratorType::THEME_COMPONENT, NULL, 'Example', 'Theme name'],
      [GeneratorType::OTHER, 'missing', 'Example', 'Name [Missing]'],
      [GeneratorType::OTHER, NULL, 'Example', 'Name'],
    ];
  }

  /**
   * Test callback.
   */
  public function testAskNameValidation(): void {
    $interviewer = $this->createInterviewer();

    $this->setStream("\nExample\n");
    $answer = $interviewer->askName();
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Name:
       ➤  The value is required.

       Name:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   *
   * @dataProvider askMachineNameProvider()
   */
  public function testAskMachineName(GeneratorType $type, ?string $name, string $expected_output): void {
    $definition = new GeneratorDefinition('test', type: $type);
    $vars = $name ? ['name' => $name] : [];
    $interviewer = $this->createInterviewer($vars, $definition);

    $this->setStream('example');
    $answer = $interviewer->askMachineName();
    self::assertSame('example', $answer);

    $format_output = static fn (string $output): string =>
      $output ? "\n $expected_output:\n ➤ " : '';
    $this->assertOutput($format_output($expected_output));
  }

  /**
   * Data provider for testAskMachineName.
   *
   * @dataProvider
   */
  public function askMachineNameProvider(): array {
    return [
      [GeneratorType::MODULE, 'Foo', 'Module machine name [foo]'],
      [GeneratorType::MODULE, NULL, 'Module machine name'],
      [GeneratorType::MODULE_COMPONENT, 'Node', 'Module machine name [node]'],
      [GeneratorType::MODULE_COMPONENT, 'example', 'Module machine name'],
      [GeneratorType::MODULE_COMPONENT, NULL, 'Module machine name'],
      [GeneratorType::THEME, 'Foo', 'Theme machine name [foo]'],
      [GeneratorType::THEME, NULL, 'Theme machine name'],
      [GeneratorType::THEME_COMPONENT, 'Olivero', 'Theme machine name [olivero]'],
      [GeneratorType::THEME_COMPONENT, 'missing', 'Theme machine name'],
      [GeneratorType::THEME_COMPONENT, NULL, 'Theme machine name'],
      [GeneratorType::OTHER, 'Missing', 'Machine name'],
      [GeneratorType::OTHER, NULL, 'Machine name'],
    ];
  }

  /**
   * Test callback.
   */
  public function testAskMachineNameFromWorkingDir(): void {
    $definition = new GeneratorDefinition('test', type: GeneratorType::MODULE_COMPONENT);
    $interviewer = $this->createInterviewer(definition: $definition);

    // -- Inside extension directory.
    $this->io->getInput()->setOption('working-dir', \DRUPAL_ROOT . '/core/modules/user/src');
    $this->setStream('example');
    $answer = $interviewer->askMachineName();
    self::assertSame('example', $answer);
    $expected_output = <<< 'TXT'

       Module machine name [user]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Outside extension directory.
    $this->io->getInput()->setOption('working-dir', \DRUPAL_ROOT . '/core/modules');
    $this->setStream('example');
    $answer = $interviewer->askMachineName();
    self::assertSame('example', $answer);
    $expected_output = <<< 'TXT'

       Module machine name:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskMachineNameAutocompletion(): void {
    $this->markTestSkipped('Create question helper for this.');
  }

  /**
   * Test callback.
   */
  public function testAskMachineNameValidation(): void {
    $interviewer = $this->createInterviewer();

    $this->setStream("\nWrong\nexample");
    $answer = $interviewer->askMachineName();
    self::assertSame('example', $answer);

    $expected_output = <<< 'TXT'

       Machine name:
       ➤  The value is required.

       Machine name:
       ➤  The value is not correct machine name.

       Machine name:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskClass(): void {
    $interviewer = $this->createInterviewer();

    // -- Default question.
    $this->setStream('Foo');
    $answer = $interviewer->askClass();
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Class:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Custom question.
    $this->setStream('Foo');
    $answer = $interviewer->askClass('Service class');
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Service class:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Validation.
    $this->setStream("\nwrong\nFoo");
    $answer = $interviewer->askClass();
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Class:
       ➤  The value is required.

       Class:
       ➤  The value is not correct class name.

       Class:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskPluginLabel(): void {
    $interviewer = $this->createInterviewer();

    // -- Default question.
    $this->setStream('Foo');
    $answer = $interviewer->askPluginLabel();
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Plugin label:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Custom question.
    $this->setStream('Foo');
    $answer = $interviewer->askPluginLabel('Label');
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Label:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Validation.
    $this->setStream("\nExample");

    $answer = $interviewer->askPluginLabel();
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Plugin label:
       ➤  The value is required.

       Plugin label:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskPluginId(): void {
    $vars = [
      'machine_name' => 'foo',
      'plugin_label' => 'Bar',
    ];
    $interviewer = $this->createInterviewer($vars);

    // -- Default question.
    $this->setStream('example');
    $answer = $interviewer->askPluginId();
    self::assertSame('example', $answer);

    $expected_output = <<< 'TXT'

       Plugin ID [foo_bar]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Custom question.
    $this->setStream('example');
    $answer = $interviewer->askPluginId('ID');
    self::assertSame('example', $answer);

    $expected_output = <<< 'TXT'

       ID [foo_bar]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Validation.
    $this->setStream("\nWrOng\nfoo");

    $answer = $interviewer->askPluginId(default: NULL);
    self::assertSame('foo', $answer);

    $expected_output = <<< 'TXT'

       Plugin ID:
       ➤  The value is required.

       Plugin ID:
       ➤  The value is not correct machine name.

       Plugin ID:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskPluginClass(): void {
    $vars = [
      'machine_name' => 'foo',
      'plugin_id' => 'Bar',
    ];
    $interviewer = $this->createInterviewer($vars);

    // -- Default question.
    $this->setStream('Example');
    $answer = $interviewer->askPluginClass();
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Plugin class [Bar]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Custom question.
    $this->setStream('Example');
    $answer = $interviewer->askPluginClass('Provide plugin class');
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Provide plugin class [Bar]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Custom default value.
    $this->setStream('Example');
    $answer = $interviewer->askPluginClass(default: 'Example');
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Plugin class [Example]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Class suffix.
    $this->setStream('Example');
    $answer = $interviewer->askPluginClass(suffix: 'Formatter');
    self::assertSame('Example', $answer);

    $expected_output = <<< 'TXT'

       Plugin class [BarFormatter]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Validation.
    $this->setStream("\nwrong\nFoo");
    $answer = $interviewer->askPluginClass(default: '');
    self::assertSame('Foo', $answer);

    $expected_output = <<< 'TXT'

       Plugin class:
       ➤  The value is required.

       Plugin class:
       ➤  The value is not correct class name.

       Plugin class:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testAskServices(): void {
    $interviewer = $this->createInterviewer([]);

    // -- Positive confirmation.
    $this->setStream("\nentity_type.manager\n\n");
    $answer = $interviewer->askServices();
    $expected_answer = [
      'entity_type.manager' => [
        'name' => 'entityTypeManager',
        'type' => 'EntityTypeManagerInterface',
        'type_fqn' => 'Drupal\Core\Entity\EntityTypeManagerInterface',
      ],
    ];
    self::assertSame($expected_answer, $answer);

    $expected_output = <<< 'TXT'

       Would you like to inject dependencies? [Yes]:
       ➤ 
       Type the service name or use arrows up/down. Press enter to continue:
       ➤ 
       Type the service name or use arrows up/down. Press enter to continue:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Negative confirmation.
    $this->setStream('No');
    $answer = $interviewer->askServices();
    self::assertSame([], $answer);

    $expected_output = <<< 'TXT'

       Would you like to inject dependencies? [Yes]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Non-existing service..
    $this->setStream("\nmissing\n\n");
    $answer = $interviewer->askServices();
    $expected_answer = [];
    self::assertSame($expected_answer, $answer);

    $expected_output = <<< 'TXT'

       Would you like to inject dependencies? [Yes]:
       ➤ 
       Type the service name or use arrows up/down. Press enter to continue:
       ➤  Service does not exists.

       Type the service name or use arrows up/down. Press enter to continue:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // -- Autocompletion.
    // @todo Test service autocompletion.
  }

  /**
   * Test callback.
   *
   * @todo Figure out how to test autocompletion.
   */
  public function testAskPermission(): void {
    $interviewer = $this->createInterviewer();

    // Test default values.
    $this->setStream('foo');
    $answer = $interviewer->askPermission();
    self::assertSame('foo', $answer);

    $expected_output = <<< 'TXT'

       Permission:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);

    // Custom values.
    $this->setStream('bar');
    $answer = $interviewer->askPermission('Route permission', 'access content');
    self::assertSame('bar', $answer);

    $expected_output = <<< 'TXT'

       Route permission [access content]:
       ➤ 
      TXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Creates interviewer.
   */
  private function createInterviewer(
    array $vars = [],
    GeneratorDefinition $definition = new GeneratorDefinition('example'),
  ): Interviewer {
    $container = self::bootstrap();
    return new Interviewer(
      $this->io,
      $vars,
      $definition,
      new ServiceInfo($container),
      match ($definition->type) {
        GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT => new ModuleInfo($container->get('module_handler')),
        GeneratorType::THEME, GeneratorType::THEME_COMPONENT => new ThemeInfo($container->get('theme_handler')),
        default => new NullExtensionInfo(),
      },
      new PermissionInfo($container->get('user.permissions')),
    );
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   */
  private function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->io->getInput()->setStream($stream);
  }

  /**
   * Asserts output.
   */
  private function assertOutput(string $expected_output): void {
    self::assertSame($expected_output, $this->io->getOutput()->fetch());
  }

}
