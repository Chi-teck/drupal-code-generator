<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:constraint command (entity type).
 */
class ConstraintTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Constraint';

  /**
   * Test callback.
   */
  public function testGenerator() {

    $data_type_output = implode("\n", [
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
      'src/Plugin/Validation/Constraint/AlphaConstraint.php' => __DIR__ . '/_constraint/entity/_constraint.php',
      'src/Plugin/Validation/Constraint/AlphaConstraintValidator.php' => __DIR__ . '/_constraint/entity/_constraint_validator.php',
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
      'src/Plugin/Validation/Constraint/BetaConstraint.php' => __DIR__ . '/_constraint/item_list/_constraint.php',
      'src/Plugin/Validation/Constraint/BetaConstraintValidator.php' => __DIR__ . '/_constraint/item_list/_constraint_validator.php',
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
      'src/Plugin/Validation/Constraint/GammaConstraint.php' => __DIR__ . '/_constraint/item/_constraint.php',
      'src/Plugin/Validation/Constraint/GammaConstraintValidator.php' => __DIR__ . '/_constraint/item/_constraint_validator.php',
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
      'src/Plugin/Validation/Constraint/DeltaConstraint.php' => __DIR__ . '/_constraint/raw_value/_constraint.php',
      'src/Plugin/Validation/Constraint/DeltaConstraintValidator.php' => __DIR__ . '/_constraint/raw_value/_constraint_validator.php',
    ];
    parent::doTest($interaction, $fixtures);

  }

}
