<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Command\Drupal_7\Component\Js;
use DrupalCodeGenerator\Tests\GeneratorTestCase;
use DrupalCodeGenerator\Command\Drupal_7\Component\Info;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
/**
 * Class InfoTest
 */
class JavascriptTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Js();
    $this->commandName = 'generate:d7:component:js-file';
    $this->answers = [
      'Example',
      'example',
    ];

    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $this->assertRegExp('/The following files have been created:/', $this->display);
    $this->assertRegExp("/example.js/", $this->display);

    $this->checkFile('example.js', __DIR__ . '/_example.js');

  }

}