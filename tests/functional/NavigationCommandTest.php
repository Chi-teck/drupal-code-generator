<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorFactory;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use DrupalCodeGenerator\Test\Functional\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Tester\TesterTrait;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Test navigation command.
 *
 * @todo Clean-up
 */
final class NavigationCommandTest extends FunctionalTestBase {

  use TesterTrait;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
    parent::tearDown();
    (new Filesystem())->remove($this->directory);
  }

  /**
   * Test callback.
   */
  public function testNavigation(): void {

    $application = $this->createApplication();

    $helper_set = $application->getHelperSet();
    $helper_set->set(new QuestionHelper());

    $container = $application->getContainer();
    $generator_factory = new GeneratorFactory($container->get('class_resolver'));
    $generators = $generator_factory->getGenerators();

    $application->addCommands($generators);
    $navigation = new Navigation();
    $application->add($navigation);

    $command_tester = new CommandTester($navigation);

    $fixture = \file_get_contents(__DIR__ . '/_navigation_fixture.txt');

    // The return symbol is used to identify user input in fixture.
    \preg_match_all('/\s([^\s]+)⏎/', $fixture, $matches);

    $command_tester->setInputs($matches[1]);
    $input = [
      '--working-dir' => $this->directory,
      '--destination' => $this->directory,
    ];

    $command_tester->execute($input);

    $expected_output = \rtrim(\preg_replace('/[^\s]+⏎/', '', $fixture));
    // @todo clean-up this.
    $default_name = \basename(\getcwd());
    $expected_output = \str_replace('%default_name%', $default_name, $expected_output);

    $output = \rtrim($command_tester->getDisplay());

    self::assertSame($expected_output, $output);

    /** @var \Symfony\Component\Console\Command\HelpCommand $help */
    $help = $application->find('help');
    $help->setCommand($navigation);
    $command_tester = new CommandTester($help);
    $command_tester->execute([]);
    $display = $command_tester->getDisplay();
    self::assertStringContainsString('Command line code generator', $display);
    self::assertStringContainsString('dcg [options] <generator>', $display);
    self::assertStringContainsString('Display navigation', $display);
    self::assertStringContainsString('List all available generators', $display);
  }

}
