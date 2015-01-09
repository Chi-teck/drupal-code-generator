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

    $this->target = 'example.js';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}