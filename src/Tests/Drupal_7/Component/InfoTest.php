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
    $this->target = 'example.info';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}