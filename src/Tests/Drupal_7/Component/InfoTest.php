<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Command\Drupal_7\Component\Info;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
/**
 * Class InfoTest
 */
class InfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Info();
    $this->commandName = 'generate:d7:component:info-file';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      '7.x-1.0',
    ];

    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $this->assertRegExp('/The following files have been created:/', $this->display);
    $this->assertRegExp("/example.info/", $this->display);

    $this->checkFile('example.info', __DIR__ . '/_example.info');

  }

}