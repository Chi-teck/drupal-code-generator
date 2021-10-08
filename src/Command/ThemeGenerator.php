<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Base class for theme generators.
 */
abstract class ThemeGenerator extends DrupalGenerator {

  protected ?string $nameQuestion = 'Theme name';
  protected ?string $machineNameQuestion = 'Theme machine name';
  protected ?int $extensionType = self::EXTENSION_TYPE_THEME;

}
