<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Output decorator helpers for the DCG style guide.
 */
class OutputStyle extends SymfonyStyle {

  private $input;
  private $output;
  private $questionHelper;

  /**
   * OutputStyle constructor.
   */
  public function __construct(InputInterface $input, OutputInterface $output, QuestionHelper $question_helper) {
    $this->input = $input;
    $this->output = $output;
    $this->questionHelper = $question_helper;
    parent::__construct($input, $output);
  }

  /**
   * {@inheritdoc}
   */
  public function askQuestion(Question $question) {
    return $this->questionHelper->ask($this->input, $this, $question);
  }

}
