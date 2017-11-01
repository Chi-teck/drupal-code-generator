<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorDiscovery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for global application options.
 */
class ApplicationTest extends TestCase {

  use WorkingDirectoryTrait;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->initWorkingDirectory();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

  /**
   * Test callback.
   */
  public function testApplication() {

    $discovery = new GeneratorDiscovery(new Filesystem());
    $generators = $discovery->getGenerators([DCG_ROOT . '/src/Command']);

    putenv('SHELL_INTERACTIVE=1');
    $application = dcg_create_application();
    $application->addCommands($generators);
    $application->setAutoExit(FALSE);

    $navigation = new Navigation($generators);
    $application->add($navigation);
    $application->setDefaultCommand($navigation->getName());

    $question_helper = new QuestionHelper();

    $input_stream = static::getInputStream("0\n");
    $question_helper->setInputStream($input_stream);

    $helper_set = $application->getHelperSet();
    $helper_set->set($question_helper);

    $tester = new ApplicationTester($application);

    // Test default command.
    $tester->run([]);
    $display = $tester->getDisplay();
    $output = rtrim(preg_replace('/(>>> 0).*/', '$1', $display));
    $expected_output = implode("\n", [
      'Select generator:',
      '  [0] ..',
      '  [1] Drupal 7',
      '  [2] Drupal 8',
      '  [3] Other',
      '  >>> 0',
    ]);
    static::assertEquals($expected_output, $output);

    // Test version option.
    $tester->run(['--version']);
    static::assertEquals("Drupal Code Generator\n", $tester->getDisplay());

    // Test directory and answers options.
    $tester->run([
      'command' => 'd8:install',
      '-d' => $this->directory,
      '-a' => '{"name":"Foo","machine_name":"foo"}',
    ]);
    $expected_output = "The following directories and files have been created or updated:\n- foo.install\n";
    static::assertEquals($expected_output, $tester->getDisplay());
    static::assertFileExists($this->directory . '/foo.install');
  }

  /**
   * Returns input stream.
   */
  protected static function getInputStream($input) {
    $stream = fopen('php://memory', 'r+', FALSE);
    fwrite($stream, $input);
    rewind($stream);
    return $stream;
  }

}
