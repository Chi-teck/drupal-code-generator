<?php

namespace DrupalCodeGenerator;

/**
 * Simple data structure to represent an asset being generated.
 */
final class Asset {

  const REPLACE = 1;
  const APPEND = 2;
  const PRESERVE = 3;

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
  private $action = self::REPLACE;

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
  private $type = 'file';

  /**
   * Getter for asset path.
   *
   * @return string
   *   Asset path.
   */
  public function getPath() :?string {
    return Utils::replaceTokens($this->path, $this->getVars());
  }

  /**
   * Getter for asset content.
   *
   * @return string
   *   Asset content.
   */
  public function getContent() :?string {
    return $this->content;
  }

  /**
   * Getter for header template.
   *
   * @return string|null
   *   Asset header template.
   */
  public function getHeaderTemplate() :?string {
    return Utils::replaceTokens($this->headerTemplate, $this->getVars());
  }

  /**
   * Getter for template.
   *
   * @return string
   *   Asset template.
   */
  public function getTemplate() :?string {
    return Utils::replaceTokens($this->template, $this->getVars());
  }

  /**
   * Getter for asset vars.
   *
   * @return array
   *   Asset template variables.
   */
  public function getVars() :array {
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
  public function getHeaderSize() :?int {
    return $this->headerSize;
  }

  /**
   * Getter for asset mode.
   *
   * @return int
   *   Asset file mode.
   */
  public function getMode() :int {
    return $this->mode ?: ($this->isDirectory() ? 0755 : 0644);
  }

  /**
   * Getter for asset type.
   *
   * @return string|null
   *   Asset type.
   */
  public function getType() :?string {
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
  public function path(?string $path) :Asset {
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
  public function content(?string $content) :Asset {
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
  public function headerTemplate(?string $header_template) :Asset {
    $this->headerTemplate = self::addTwigExtension($header_template);
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
  public function template(?string $template) :Asset {
    $this->template = self::addTwigExtension($template);
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
  public function vars(array $vars) :Asset {
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
  public function action($action) :Asset {
    $this->action = $action;
    return $this;
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
  public function headerSize(?int $header_size) :Asset {
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
  public function mode(?int $mode) :Asset {
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
  public function type(string $type) :Asset {
    $this->type = $type;
    return $this;
  }

  /**
   * Determines if the asset is a directory.
   *
   * @return bool
   *   True if the asset is a directory, false otherwise.
   */
  public function isDirectory() :bool {
    return $this->getType() == 'directory';
  }

  /**
   * Implements the magic __toString() method.
   */
  public function __toString() :string {
    return $this->getPath() ?: '';
  }

  /**
   * Adds twig extension if needed.
   */
  private static function addTwigExtension(?string $template) {
    if ($template && pathinfo($template, PATHINFO_EXTENSION) != 'twig') {
      $template .= '.twig';
    }
    return $template;
  }

}
