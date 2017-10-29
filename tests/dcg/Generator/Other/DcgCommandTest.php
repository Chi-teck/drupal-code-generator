<?php

namespace DrupalCodeGenerator\Tests\Other;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for other:dcg-command command.
 */
class DcgCommandTest extends GeneratorBaseTest {

  protected $class = 'Other\DcgCommand';

  protected $interaction = [
    'Command name [custom:example]: ' => 'custom:example',
    'Command description [Some description]: ' => 'Some description',
    'Command alias [example]: ' => 'example',
  ];

  protected $fixtures = [
    'custom/Example.php' => __DIR__ . '/_dcg_command.php',
    'custom/example.twig' => __DIR__ . '/_dcg_command_template.twig',
  ];

}
