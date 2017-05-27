<?php

namespace DrupalCodeGenerator\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for a command interaction.
 */
class InteractionTest extends TestCase {

  protected $destination;

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->destination = DCG_SANDBOX . '/example';

    $command_class = 'DrupalCodeGenerator\Command\Drupal_8\Plugin\Block';
    /** @var \Symfony\Component\Console\Command\Command $command */
    $command = new $command_class();

    $commandTester = new CommandTester($command);

    $application = dcg_create_application();
    $application->add($command);

    $helper = $command->getHelper('question');

    $answers = ['Foo', 'foo', 'Bar', 'foo_bar', 'custom'];
    $helper->setInputStream($this->getInputStream(implode("\n", $answers)));

    $commandTester->execute(['command' => $command->getName(), '--directory' => $this->destination]);

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
