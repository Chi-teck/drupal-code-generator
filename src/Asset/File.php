<?php

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Utils;
use function parent;

/**
 * Simple data structure to represent a file being generated.
 */
final class File extends Asset {

  const ACTION_REPLACE = 1;
  const ACTION_APPEND = 2;
  const ACTION_SKIP = 3;

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
   * @var int
   */
  private $headerSize = 0;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0644);
  }

  /**
   * Getter for asset content.
   *
   * @return string|null
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
    return $this->headerTemplate;
  }

  /**
   * Getter for template.
   *
   * @return string|null
   *   Asset template.
   */
  public function getTemplate(): ?string {
    return $this->template;
  }

  /**
   * Getter for inline template.
   *
   * @return string|null
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
   * @return int
   *   Asset header size.
   */
  public function getHeaderSize(): int {
    return $this->headerSize;
  }

  /**
   * Setter for asset content.
   *
   * @param string|null $content
   *   Asset content.
   *
   * @return self
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
   * @return self
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
   * @return self
   *   The asset.
   */
  public function template(?string $template): Asset {
    if ($template !== NULL) {
      $this->template = self::addTwigFileExtension($template);
    }
    return $this;
  }

  /**
   * Setter for asset template.
   *
   * @param string|null $inline_template
   *   The template string to render.
   *
   * @return self
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
   * @return self
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
   * @return self
   *   The asset.
   *
   * @todo remove
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
   * @return self
   *   The asset.
   */
  public function replaceIfExists() {
    return $this->action(self::ACTION_REPLACE);
  }

  /**
   * Sets "append" action.
   *
   * @return self
   *   The asset.
   */
  public function appendIfExists() {
    return $this->action(self::ACTION_APPEND);
  }

  /**
   * Sets "skip" action.
   *
   * @return self
   *   The asset.
   */
  public function skipIfExists() {
    return $this->action(self::ACTION_SKIP);
  }

  /**
   * Setter for asset header size.
   *
   * @param int $header_size
   *   Asset header size.
   *
   * @return \DrupalCodeGenerator\Asset\Asset
   *   The asset.
   */
  public function headerSize(int $header_size): Asset {
    if ($header_size <= 0) {
      throw new \InvalidArgumentException("Header size must be greater than or equal to 0. ");
    }
    $this->headerSize = $header_size;
    return $this;
  }

  /**
   * Adds Twig extension if needed.
   */
  private static function addTwigFileExtension(string $template): string {
    if ($template && pathinfo($template, PATHINFO_EXTENSION) != 'twig') {
      $template .= '.twig';
    }
    return $template;
  }

  /**
   * {@inheritdoc}
   */
  public function replaceTokens(array $vars): void {
    parent::replaceTokens($vars);
    if ($this->template) {
      $this->template = Utils::replaceTokens($this->template, $vars);
    }
    if ($this->headerTemplate) {
      $this->headerTemplate = Utils::replaceTokens($this->headerTemplate, $vars);
    }
  }

}
