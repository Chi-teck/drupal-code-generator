<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\Renderer;

/**
 * Simple data structure to represent an asset being generated.
 */
class Asset {

  /**
   * Asset path.
   *
   * @var string
   */
  protected $path;

  /**
   * Asset content.
   *
   * @var string
   */
  protected $content;

  /**
   * Twig template to render header.
   *
   * @var string
   */
  protected $headerTemplate;

  /**
   * Twig template to render main content.
   *
   * @var string
   */
  protected $template;

  /**
   * Template variables.
   *
   * @var array
   */
  protected $vars = [];

  /**
   * Action.
   *
   * This defines an action to take if specified file already exists.
   *
   * @var string
   */
  protected $action = 'replace';

  /**
   * Header size.
   *
   * @var int
   */
  protected $headerSize = 0;

  /**
   * Asset mode.
   *
   * @var int
   */
  protected $mode;

  /**
   * Asset type (file or directory).
   *
   * @var string
   */
  protected $type = 'file';

  /**
   * Getter for asset path.
   *
   * @return string
   *   Asset path.
   */
  public function getPath() {
    return Utils::tokenReplace($this->path, $this->getVars());
  }

  /**
   * Getter for asset content.
   *
   * @return string
   *   Asset content.
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * Getter for header template.
   *
   * @return string
   *   Asset header template.
   */
  public function getHeaderTemplate() {
    return $this->headerTemplate;
  }

  /**
   * Getter for template.
   *
   * @return string
   *   Asset template.
   */
  public function getTemplate() {
    return $this->template;
  }

  /**
   * Getter for asset vars.
   *
   * @return array
   *   Asset template variables.
   */
  public function getVars() {
    return $this->vars;
  }

  /**
   * Getter for asset action.
   *
   * @return string
   *   Asset action.
   */
  public function getAction() {
    return $this->action;
  }

  /**
   * Getter for asset header size.
   *
   * @return string
   *   Asset header size.
   */
  public function getHeaderSize() {
    return $this->headerSize;
  }

  /**
   * Getter for asset mode.
   *
   * @return string
   *   Asset file mode.
   */
  public function getMode() {
    return $this->mode ?: ($this->isDirectory() ? 0755 : 0644);
  }

  /**
   * Getter for asset type.
   *
   * @return string
   *   Asset type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Setter for asset path.
   *
   * @param string $path
   *   Asset path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function path($path) {
    $this->path = $path;
    return $this;
  }

  /**
   * Setter for asset content.
   *
   * @param string $content
   *   Asset content.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function content($content) {
    $this->content = $content;
    return $this;
  }

  /**
   * Setter for asset header template.
   *
   * @param string $header_template
   *   Asset template.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function headerTemplate($header_template) {
    $this->headerTemplate = $header_template;
    return $this;
  }

  /**
   * Setter for asset template.
   *
   * @param string $template
   *   Asset template.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function template($template) {
    $this->template = $template;
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
  public function vars(array $vars) {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Setter for asset action.
   *
   * @param string $action
   *   Asset action.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function action($action) {
    $this->action = $action;
    return $this;
  }

  /**
   * Setter for asset header size.
   *
   * @param int $header_size
   *   Asset header size.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function headerSize($header_size) {
    $this->headerSize = $header_size;
    return $this;
  }

  /**
   * Setter for asset mode.
   *
   * @param string $mode
   *   Asset mode.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  public function mode($mode) {
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
  public function type($type) {
    $this->type = $type;
    return $this;
  }

  /**
   * Determines if the asset is a directory.
   *
   * @return bool
   *   True if the asset is a directory, false otherwise.
   */
  public function isDirectory() {
    return $this->getType() == 'directory';
  }

  /**
   * Renders the asset template.
   *
   * @param \DrupalCodeGenerator\Helper\Renderer $renderer
   *   Renderer helper.
   */
  public function render(Renderer $renderer) {
    if (!$this->isDirectory() && is_null($this->getContent())) {
      $content = '';
      if ($header_template = $this->getHeaderTemplate()) {
        $content .= $renderer->render($header_template, $this->getVars()) . "\n";
      }
      $content .= $renderer->render($this->getTemplate(), $this->getVars());
      $this->content($content);
    }
  }

}
