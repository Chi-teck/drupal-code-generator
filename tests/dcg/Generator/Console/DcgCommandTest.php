<?php

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:dcg-command command.
 */
final class DcgCommandTest extends BaseGeneratorTest {

  protected $class = 'Console\DcgCommand';

  protected $interaction = [
    'Command name [custom:example]:' => 'custom:example',
    'Command description:' => 'Some description',
    'Command alias [example]:' => 'example',
  ];

  protected $fixtures = [
    'custom/Example.php' => '/_dcg_command.php',
    'custom/example.twig' => '/_dcg_command_template.twig',
  ];

}
