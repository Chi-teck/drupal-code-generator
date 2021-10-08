<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:services command.
 */
final class ServicesTest extends BaseGeneratorTest {

  protected $class = 'Yml\Services';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];
  protected $fixtures = [
    'foo.services.yml' => '/_services.yml',
  ];

}
