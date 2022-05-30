<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Constraint;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:constraint generator.
 */
final class ConstraintTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_constraint';

  public function testEntityConstraint(): void {
    $input = [
      'foo',
      'Alpha',
      'FooAlpha',
      'AlphaConstraint',
      '1',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Constraint ID [FooAlpha]:
     ➤ 

     Plugin class [AlphaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/AlphaConstraint.php
     • src/Plugin/Validation/Constraint/AlphaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_entity';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/AlphaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/AlphaConstraintValidator.php');
  }

  public function testItemListConstraint(): void {
    $input = [
      'foo',
      'Beta',
      'FooBeta',
      'BetaConstraint',
      '2',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Constraint ID [FooBeta]:
     ➤ 

     Plugin class [BetaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/BetaConstraint.php
     • src/Plugin/Validation/Constraint/BetaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_item_list';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/BetaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/BetaConstraintValidator.php');
  }

  public function testItemConstraint(): void {
    $input = [
      'foo',
      'Gamma',
      'FooGamma',
      'GammaConstraint',
      '3',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Constraint ID [FooGamma]:
     ➤ 

     Plugin class [GammaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/GammaConstraint.php
     • src/Plugin/Validation/Constraint/GammaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_item';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/GammaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/GammaConstraintValidator.php');
  }

  public function testRowValueConstraint(): void {
    $input = [
      'foo',
      'Delta',
      'FooDelta',
      'DeltaConstraint',
      '4',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Constraint ID [FooDelta]:
     ➤ 

     Plugin class [DeltaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/DeltaConstraint.php
     • src/Plugin/Validation/Constraint/DeltaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_raw_value';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraintValidator.php');
  }

}
