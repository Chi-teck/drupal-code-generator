<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Command\Other\DrushCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class DrushCommandTest
 * @package DrupalCodeGenerator\Tests\Other
 */
class DrushCommandTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new DrushCommand();
    $this->commandName = 'generate:other:drush-command';
    $this->answers = [
      'Example',
      'example',
      'test',
      'ts',
      'foo',
      'bar',
    ];

    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $this->assertRegExp('/The following files have been created:/', $this->display);
    $this->assertRegExp("/example.drush.inc/", $this->display);

    $this->checkFile('example.drush.inc', __DIR__ . '/_example.drush.inc');

  }

}