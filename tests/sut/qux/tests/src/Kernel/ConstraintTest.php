<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\KernelTests\KernelTestBase;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * A test for constraint plugin.
 *
 * @todo Add tests for entity and field constraints.
 */
#[Group('DCG')]
final class ConstraintTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testRawValueConstraint(): void {
    self::assertSame('', (string) $this->validate('correct'));

    $expected_violations = <<< 'TXT'
      Object(Drupal\Core\TypedData\Plugin\DataType\StringData):
          @todo Specify error message here.

      TXT;
    self::assertSame($expected_violations, (string) $this->validate('wrong'));
  }

  /**
   * Validates a string using 'QuxConstraint'.
   */
  private function validate(string $value): ConstraintViolationListInterface {
    $definition = DataDefinition::create('string')->addConstraint('QuxConstraint');
    return $this->container
      ->get('typed_data_manager')
      ->create($definition, $value)
      ->validate();
  }

}
