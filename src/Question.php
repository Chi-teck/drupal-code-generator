<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Question\Question as BaseQuestion;


class Question extends BaseQuestion {

  public function __construct($question, $default = null) {

    $question = "<info>$question</info>";
    if ($default) {
      $question .= " [<comment>$default</comment>]";
    }
    $question .= ': ';

    return parent::__construct($question, $default = null);

  }

}