<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\OutputStyleInterface;
use Symfony\Component\Console\Helper\Helper as BaseHelper;

/**
 * Base class for DCG helpers.
 */
abstract class Helper extends BaseHelper {

  /**
   * Output style.
   *
   * @var \DrupalCodeGenerator\OutputStyleInterface
   */
  private $io;

  /**
   * Returns Output Style.
   */
  public function io() :OutputStyleInterface {
    if (!$this->io) {
      /** @var \DrupalCodeGenerator\Helper\OutputStyleFactory $output_style_factory */
      $output_style_factory = $this->getHelperSet()->get('output_style_factory');
      $this->io = $output_style_factory->getOutputStyle();
    }
    return $this->io;
  }

}
