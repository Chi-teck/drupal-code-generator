<?php

namespace DrupalCodeGenerator;

/**
 * Simple data structure to represent an asset being generated.
 */
final class Asset {

  const ACTION_REPLACE = 1;
  const ACTION_APPEND = 2;
  const ACTION_SKIP = 3;

  const TYPE_FILE = 1;
  const TYPE_DIRECTORY = 2;

  /**
   * Asset path.
   *
   * @var string|null
   */
  private $path;

  /**
   * Asset content.
   *
   * @var string|null
   */
  private $content;

  /**
   * Twig template to render header.
   *
   * @var string|null
   */
  private $headerTemplate;

  /**
   * Twig template to render main content.
   *
   * @var string|null
   */
  private $template;

  /**
   * The template string to render.
   *
   * @var string|null
   */
  private $inlineTemplate;

  /**
   * Template variables.
   *
   * @var array
   */
  private $vars = [];

  /**
   * Action.
   *
   * An action to take if specified file already exists.
   *
   * @var string|callable
   */
  private $action = self::ACTION_REPLACE;

  /**
   * Header size.
   *
   * @var int|null
   */
  private $headerSize = 0;

  /**
   * Asset mode.
   *
   * @var int|null
   */
  private $mode;

  /**
   * Asset type (file or directory).
   *
   * @var string
   */
  private $type = self::TYPE_FILE;

  /**
   * Getter for asset path.
   *
   * @return string
   *   Asset path.
   */
  public function getPath(): ?string {
    return Utils::replaceTokens($this->path, $this->getVars());
  }

  /**
   * Getter for asset content.
   *
   * @return string
   *   Asset content.
   */
  public function getContent(): ?string {
    return $this->content;
  }

  /**
   * Getter for header template.
   *
   * @return string|null
   *   Asset header template.
   */
  public function getHeaderTemplate(): ?string {
    return Utils::replaceTokens($this->headerTemplate, $this->getVars());
  }

  /**
   * Getter for template.
   *
   * @return string
   *   Asset template.
   */
  public function getTemplate(): ?string {
    return Utils::replaceTokens($this->template, $this->getVars());
  }

  /**
   * Getter for inline template.
   *
   * @return string
   *   Asset template.
   */
  public function getInlineTemplate(): ?string {
    return $this->inlineTemplate;
  }

  /**
   * Getter for asset vars.
   *
   * @return array
   *   Asset template variables.
   */
  public function getVars(): array {
    return $this->vars;
  }

  /**
   * Getter for asset action.
   *
   * @return string|callable
   *   Asset action.
   */
  public function getAction() {
    return $this->action;
  }

  /**
   * Getter for asset header size.
   *
   * @return int|null
   *   Asset header size.
   */
  public function getHeaderSize(): ?int {
    return $this->headerSize;
  }

  /**
   * Getter for asset mode.
   *
   * @return int
   *   Asset file mode.
   */
  public function getMode(): int {
    return $this->mode ?: ($this->isDirectory() ? 0755 : 0644);
  }

  /**
   * Getter for asset type.
   *
   * @return string|null
   *   Asset type.
   */
  public function getType(): ?string {
    return $this->type;
  }

  /**
   * Setter for asset path.
   *
   * @param string|null $path
   *   Asset path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function path(?string $path): Asset {
    $this->path = $path;
    return $this;
  }

  /**
   * Setter for asset content.
   *
   * @param string|null $content
   *   Asset content.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function content(?string $content): Asset {
    $this->content = $content;
    return $this;
  }

  /**
   * Setter for asset header template.
   *
   * @param string|null $header_template
   *   Asset template.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function headerTemplate(?string $header_template): Asset {
    $this->headerTemplate = self::addTwigFileExtension($header_template);
    return $this;
  }

  /**
   * Setter for asset template.
   *
   * @param string|null $template
   *   Asset template.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function template(?string $template): Asset {
    $this->template = self::addTwigFileExtension($template);
    return $this;
  }

  /**
   * Setter for asset template.
   *
   * @param string|null $inline_template
   *   The template string to render.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function inlineTemplate(?string $inline_template): Asset {
    $this->inlineTemplate = $inline_template;
    return $this;
  }

  /**
   * Setter for asset vars.
   *
   * @param array $vars
   *   Asset template variables.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function vars(array $vars): Asset {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Setter for asset action.
   *
   * @param string|callable $action
   *   Asset action.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function action($action): Asset {
    if (!is_callable($action)) {
      $supported_actions = [
        self::ACTION_REPLACE,
        self::ACTION_APPEND,
        self::ACTION_SKIP,
      ];
      if (!in_array($action, $supported_actions)) {
        throw new \InvalidArgumentException("Unsupported assert action $action.");
      }
    }
    $this->action = $action;
    return $this;
  }

  /**
   * Sets "replace" action.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function replaceIfExists() {
    return $this->action(self::ACTION_REPLACE);
  }

  /**
   * Sets "append" action.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function appendIfExists() {
    return $this->action(self::ACTION_APPEND);
  }

  /**
   * Sets "skip" action.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function skipIfExists() {
    return $this->action(self::ACTION_SKIP);
  }

  /**
   * Setter for asset header size.
   *
   * @param int|null $header_size
   *   Asset header size.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function headerSize(?int $header_size): Asset {
    if ($header_size <= 0) {
      throw new \InvalidArgumentException("Header size must be greater than or equal to 0. ");
    }
    $this->headerSize = $header_size;
    return $this;
  }

  /**
   * Setter for asset mode.
   *
   * @param int|null $mode
   *   Asset mode.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function mode(?int $mode): Asset {
    if ($mode < 0000 || $mode > 0777) {
      throw new \InvalidArgumentException("Incorrect mode value $mode.");
    }
    $this->mode = $mode;
    return $this;
  }

  /**
   * Setter for asset type.
   *
   * @param string $type
   *   Asset type.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function type(string $type): Asset {
    if ($type != self::TYPE_FILE && $type != self::TYPE_DIRECTORY) {
      throw new \InvalidArgumentException("Unsupported assert type $type.");
    }
    $this->type = $type;
    return $this;
  }

  /**
   * Determines if the asset is a directory.
   *
   * @return bool
   *   True if the asset is a directory, false otherwise.
   */
  public function isDirectory(): bool {
    return $this->getType() == self::TYPE_DIRECTORY;
  }

  /**
   * Implements the magic __toString() method.
   */
  public function __toString(): string {
    return $this->getPath() ?: '';
  }

  /**
   * Adds Twig extension if needed.
   */
  private static function addTwigFileExtension(?string $template) {
    if ($template && pathinfo($template, PATHINFO_EXTENSION) != 'twig') {
      $template .= '.twig';
    }
    return $template;
  }

}
