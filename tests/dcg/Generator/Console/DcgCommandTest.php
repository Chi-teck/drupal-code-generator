<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for console:dcg-command command.
 */
final class DcgCommandTest extends BaseGeneratorTest {

  protected string $class = 'Console\DcgCommand';

  protected array $interaction = [
    'Command name [custom:example]:' => 'custom:example',
    'Command description:' => 'Some description',
    'Command alias [example]:' => 'example',
  ];

  protected array $fixtures = [
    'custom/Example.php' => '/_dcg_command.php',
    'custom/example.twig' => '/_dcg_command_template.twig',
  ];

}
