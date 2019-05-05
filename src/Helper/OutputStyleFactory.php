<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\InputAwareInterface;
use DrupalCodeGenerator\InputAwareTrait;
use DrupalCodeGenerator\OutputAwareInterface;
use DrupalCodeGenerator\OutputAwareTrait;
use DrupalCodeGenerator\OutputStyle;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Defines the output style factory.
 */
class OutputStyleFactory extends Helper implements InputAwareInterface, OutputAwareInterface {

  use InputAwareTrait;
  use OutputAwareTrait;

  /**
   * Output style.
   *
   * @var \Symfony\Component\Console\Style\StyleInterface
   */
  private $outputStyle;

  /**
   * {@inheritdoc}
   */
  public function getName() :string {
    return 'output_style_factory';
  }

  /**
   * Creates output style.
   *
   * @return \Symfony\Component\Console\Style\StyleInterface
   *   Output style.
   */
  public function getOutputStyle() :StyleInterface {
    if (!$this->outputStyle) {
      /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
      $question_helper = $this->getHelperSet()->get('question');
      $this->outputStyle = new OutputStyle($this->input, $this->output, $question_helper);
    }
    return $this->outputStyle;
  }

}
