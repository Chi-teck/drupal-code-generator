<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:constraint command (entity type).
 */
final class ConstraintTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Constraint';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $data_type_output = \implode("\n", [
      'Type of data to validate [Item list]:',
      '  [1] Entity',
      '  [2] Item list',
      '  [3] Item',
      '  [4] Raw value',
    ]);

    // Entity type.
    $interaction = [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Plugin label [Example]:' => 'Alpha',
      'Constraint ID [FooAlpha]:' => 'FooAlpha',
      'Plugin class [AlphaConstraint]:' => 'AlphaConstraint',
      $data_type_output => 1,
    ];
    $fixtures = [
      'src/Plugin/Validation/Constraint/AlphaConstraint.php' => '/_constraint/entity/_constraint.php',
      'src/Plugin/Validation/Constraint/AlphaConstraintValidator.php' => '/_constraint/entity/_constraint_validator.php',
    ];
    parent::doTest($interaction, $fixtures);

    // Item list type.
    $interaction = [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Plugin label [Example]:' => 'Beta',
      'Constraint ID [FooBeta]:' => 'FooBeta',
      'Plugin class [BetaConstraint]:' => 'BetaConstraint',
      $data_type_output => 2,
    ];
    $fixtures = [
      'src/Plugin/Validation/Constraint/BetaConstraint.php' => '/_constraint/item_list/_constraint.php',
      'src/Plugin/Validation/Constraint/BetaConstraintValidator.php' => '/_constraint/item_list/_constraint_validator.php',
    ];
    parent::doTest($interaction, $fixtures);

    // Item type.
    $interaction = [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Plugin label [Example]:' => 'Gamma',
      'Constraint ID [FooGamma]:' => 'FooGamma',
      'Plugin class [GammaConstraint]:' => 'GammaConstraint',
      $data_type_output => 3,
    ];
    $fixtures = [
      'src/Plugin/Validation/Constraint/GammaConstraint.php' => '/_constraint/item/_constraint.php',
      'src/Plugin/Validation/Constraint/GammaConstraintValidator.php' => '/_constraint/item/_constraint_validator.php',
    ];
    parent::doTest($interaction, $fixtures);

    // Raw value type.
    $interaction = [
      'Module name [%default_name%]:' => 'Foo',
      'Module machine name [foo]:' => 'foo',
      'Plugin label [Example]:' => 'Delta',
      'Constraint ID [FooDelta]:' => 'FooDelta',
      'Plugin class [DeltaConstraint]:' => 'DeltaConstraint',
      $data_type_output => 4,
    ];
    $fixtures = [
      'src/Plugin/Validation/Constraint/DeltaConstraint.php' => '/_constraint/raw_value/_constraint.php',
      'src/Plugin/Validation/Constraint/DeltaConstraintValidator.php' => '/_constraint/raw_value/_constraint_validator.php',
    ];
    parent::doTest($interaction, $fixtures);

  }

}
