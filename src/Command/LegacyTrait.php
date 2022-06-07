<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

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

}
