<?php

namespace DrupalCodeGenerator\Command;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Returns command label.
   *
   * @return string|null
   *   A label suitable for navigation command.
   */
  public function getLabel();

  /**
   * Returns list of assets to dump.
   *
   * @return \DrupalCodeGenerator\Asset[]
   *   An array of assets.
   */
  public function getAssets();

  /**
   * Sets working directory.
   *
   * @param string|null $directory
   *   The working directory.
   */
  public function setDirectory($directory);

  /**
   * Returns current working directory.
   *
   * @return string|null
   *   The directory.
   */
  public function getDirectory();

  /**
   * Sets destination.
   *
   * @param mixed $destination
   *   The destination.
   */
  public function setDestination($destination);

  /**
   * Returns destination.
   *
   * @return mixed
   *   The recommended destination for dumped files.
   *   This value can be handy to determine the nature of the generated code
   *   (module, theme, etc). The DCG itself does not make use of it when saving
   *   files because of lack of Drupal context however all its generators have
   *   this property configured.
   *   The destination format is as follows:
   *   - modules (new module)
   *   - modules/% (existing module)
   *   - themes (new theme)
   *   - themes/% (existing theme)
   *   - profiles (new profile)
   *   - sites/default
   *   Note that the paths without leading slash are related to Drupal root
   *   directory.
   */
  public function getDestination();

}
