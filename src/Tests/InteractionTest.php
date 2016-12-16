<?php

namespace DrupalCodeGenerator\Tests;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for a command interaction.
 */
class InteractionTest extends \PHPUnit_Framework_TestCase {

  protected $destination;

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->destination = DCG_SANDBOX . '/example';

    $command_class = 'DrupalCodeGenerator\Commands\Drupal_8\Plugin\Block';
    /** @var \Symfony\Component\Console\Command\Command $command */
    $command = $command_class::create([DCG_ROOT . '/src/Templates']);

    $commandTester = new CommandTester($command);

    $application = new Application();
    $application->add($command);

    $helper = $command->getHelper('question');

    $answers = ['Foo', 'foo', 'Bar', 'foo_bar', 'custom'];
    $helper->setInputStream($this->getInputStream(implode("\n", $answers)));

    $commandTester->execute(['command' => $command->getName(), '--destination' => $this->destination]);

    $expected_output = [
      'Module name [Example]: ',
      'Module machine name [foo]: ',
      'Block admin label [Example]: ',
      'Plugin ID [foo_bar]: ',
      'Block category [Custom]: ',
      "The following directories and files have been created or updated:\n- src/Plugin/Block/BarBlock.php\n",
    ];

    $this->assertEquals($commandTester->getDisplay(), implode($expected_output));
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

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    (new Filesystem())->remove($this->destination);
  }

}
