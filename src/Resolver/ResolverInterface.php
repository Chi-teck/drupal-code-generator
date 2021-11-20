<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Resolver;

interface ResolverInterface {

  public function __invoke(string $existing_content, string $generated_content): string;

}
