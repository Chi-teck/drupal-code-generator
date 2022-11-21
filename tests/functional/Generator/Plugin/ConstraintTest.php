<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Constraint;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:constraint generator.
 */
final class ConstraintTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_constraint';

  /**
   * Test callback.
   */
  public function testEntityConstraint(): void {
    $input = [
      'foo',
      'Foo',
      'Alpha',
      'FooAlpha',
      'AlphaConstraint',
      '1',
      'No',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [FooAlpha]:
     ➤ 

     Plugin class [AlphaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/AlphaConstraint.php
     • src/Plugin/Validation/Constraint/AlphaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_entity';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/AlphaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/AlphaConstraintValidator.php');
  }

  /**
   * Test callback.
   */
  public function testItemListConstraint(): void {
    $input = [
      'foo',
      'Foo',
      'Beta',
      'FooBeta',
      'BetaConstraint',
      '2',
      'No',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [FooBeta]:
     ➤ 

     Plugin class [BetaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/BetaConstraint.php
     • src/Plugin/Validation/Constraint/BetaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_item_list';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/BetaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/BetaConstraintValidator.php');
  }

  /**
   * Test callback.
   */
  public function testItemConstraint(): void {
    $input = [
      'foo',
      'Foo',
      'Gamma',
      'FooGamma',
      'GammaConstraint',
      '3',
      'No',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [FooGamma]:
     ➤ 

     Plugin class [GammaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/GammaConstraint.php
     • src/Plugin/Validation/Constraint/GammaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_item';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/GammaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/GammaConstraintValidator.php');
  }

  /**
   * Test callback.
   */
  public function testRawValueConstraint(): void {
    $input = [
      'foo',
      'Foo',
      'Delta',
      'FooDelta',
      'DeltaConstraint',
      '4',
      'No',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [FooDelta]:
     ➤ 

     Plugin class [DeltaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/DeltaConstraint.php
     • src/Plugin/Validation/Constraint/DeltaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_raw_value';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraintValidator.php');
  }

  /**
   * Test callback.
   */
  public function testRawValueConstraintWithDependencies(): void {
    $input = [
      'foo',
      'Foo',
      'Delta',
      'FooDelta',
      'DeltaConstraint',
      '4',
      'Yes',
      'database',
      '',
    ];
    $this->execute(Constraint::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to constraint generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [FooDelta]:
     ➤ 

     Plugin class [DeltaConstraint]:
     ➤ 

     Type of data to validate [Item list]:
      [1] Entity
      [2] Item list
      [3] Item
      [4] Raw value
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/Validation/Constraint/DeltaConstraint.php
     • src/Plugin/Validation/Constraint/DeltaConstraintValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps/_raw_value';
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraint.php');
    $this->assertGeneratedFile('src/Plugin/Validation/Constraint/DeltaConstraintValidator.php');
  }

}
