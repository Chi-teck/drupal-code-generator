<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Legacy trait.
 *
 * Contains properties and methods that will be removed from the base Generator
 * classes.
 *
 * @internal
 */
trait LegacyTrait {

  /**
   * The command name.
   *
   * @deprecated
   */
  protected string $name;

  /**
   * The command description.
   *
   * @deprecated
   */
  protected string $description;

  /**
   * The command alias.
   *
   * @deprecated
   */
  protected string $alias = '';

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpDeprecationInspection
   */
  protected function configure(): void {
    parent::configure();
    if (isset($this->name)) {
      @\trigger_error('Generator::name property is deprecated. Use PHP attributes instead.', \E_USER_DEPRECATED);
      $this->setName($this->name);
    }
    if (isset($this->description)) {
      @\trigger_error('Generator::description property is deprecated. Use PHP attributes instead.', \E_USER_DEPRECATED);
      $this->setDescription($this->description);
    }
    if ($this->alias) {
      @\trigger_error('Generator::alias property is deprecated. Use PHP attributes instead.', \E_USER_DEPRECATED);
      $this->setAliases([$this->alias]);
    }
  }

  /**
   * Asks a question.
   *
   * @deprecated
   */
  protected function ask(string $question, ?string $default = NULL, string|callable|NULL $validator = NULL): mixed {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    if ($default) {
      $default = Utils::stripSlashes(Utils::replaceTokens($default, $this->vars));
    }

    // Allow the validators to be referenced in a short form like
    // '::validateMachineName'.
    if (\is_string($validator) && \str_starts_with($validator, '::')) {
      $validator = [static::class, \substr($validator, 2)];
    }
    return $this->io->ask($question, $default, $validator);
  }

  /**
   * Asks for confirmation.
   *
   * @deprecated
   */
  protected function confirm(string $question, bool $default = TRUE): bool {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    return $this->io->confirm($question, $default);
  }

  /**
   * Asks a choice question.
   *
   * @deprecated
   */
  protected function choice(string $question, array $choices, ?string $default = NULL, bool $multiselect = FALSE): array|string {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));

    // The choices can be an associative array.
    $choice_labels = \array_values($choices);
    // Start choices list form '1'.
    \array_unshift($choice_labels, NULL);
    unset($choice_labels[0]);

    $question = new ChoiceQuestion($question, $choice_labels, $default);
    $question->setMultiselect($multiselect);

    // Do not use IO choice here as it prints choice key as default value.
    // @see \Symfony\Component\Console\Style\SymfonyStyle::choice().
    $answer = $this->io->askQuestion($question);

    // @todo Create a test for this.
    $get_key = static fn (string $answer): string => \array_search($answer, $choices);
    return \is_array($answer) ? \array_map($get_key, $answer) : $get_key($answer);
  }

}
