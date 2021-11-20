<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Resolver;

use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard as StandardPrinter;

/**
 * A resolver for hooks that return nothing.
 */
final class VoidHookResolver implements ResolverInterface {

  private string $hookName;
  private ?ParserFactory $parserFactory;
  private ?StandardPrinter $printer;

  public function __construct(string $hook_name, ?ParserFactory $parserFactory = NULL, ?StandardPrinter $printer = NULL) {
    $this->hookName = $hook_name;
    if (!$parserFactory) {
      $this->parserFactory = new ParserFactory();
    }
    if (!$printer) {
      $this->printer = new StandardPrinter();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function __invoke(string $existing_content, string $generated_content): string {
    $parser = $this->parserFactory->create(ParserFactory::ONLY_PHP7);

    $generated_ast = $parser->parse($generated_content);
    foreach ($generated_ast as $stm) {
      if ($stm->getType() === 'Stmt_Function') {
        if ($stm->name->name === $this->hookName) {
          echo $this->printer->prettyPrintFile($stm->stmts);
        }
      }
    }

    $existing_ast = $parser->parse($existing_content);
    foreach ($existing_ast as $stm) {
      if ($stm->getType() === 'Stmt_Function') {
        if ($stm->name->name === $this->hookName) {
          echo $this->printer->prettyPrintFile($stm->stmts);
        }
      }
    }

    return $existing_content;
  }

}
