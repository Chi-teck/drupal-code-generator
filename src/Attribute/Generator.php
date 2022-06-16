<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Attribute;

use DrupalCodeGenerator\GeneratorType;

/**
 * Service tag to autoconfigure generators.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Generator {

  public function __construct(
    public string $name,
    public ?string $description = NULL,
    public array $aliases = [],
    public bool $hidden = FALSE,
    public ?string $templatePath = NULL,
    public GeneratorType $type = GeneratorType::OTHER,
    public ?string $label = NULL,
  ) {}

}
