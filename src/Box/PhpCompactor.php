<?php

namespace DrupalCodeGenerator\Box;

use Herrera\Box\Compactor\Compactor;

/**
 * A PHP source code compactor.
 */
class PhpCompactor extends Compactor {

  /**
   * {@inheritdoc}
   */
  protected $extensions = ['php'];

  /**
   * {@inheritdoc}
   */
  public function compact($contents) {
    // php_strip_whitespace() takes file name as argument so we have
    // to save the contents to a temporary file.
    $temp_file = tempnam(sys_get_temp_dir(), 'dcg-');
    file_put_contents($temp_file, $contents);
    $contents = php_strip_whitespace($temp_file);
    unlink($temp_file);
    return $contents;
  }

}
