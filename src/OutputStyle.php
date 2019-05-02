<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\QuestionHelper;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Output decorator helpers for the DCG style guide.
 */
class OutputStyle extends SymfonyStyle {

  /**
   * Console input.
   *
   * @var \Symfony\Component\Console\Input\InputInterface
   */

  private $input;

  /**
   * Console output.
   *
   * @var \Symfony\Component\Console\Output\OutputInterface
   */
  private $output;

  /**
   * Question helper.
   *
   * @var \DrupalCodeGenerator\Helper\QuestionHelper
   */
  private $questionHelper;

  /**
   * OutputStyle constructor.
   */
  public function __construct(InputInterface $input, OutputInterface $output) {
    $this->input = $input;
    $this->output = $output;
    parent::__construct($input, $output);
  }

  /**
   * Sets question helper.
   */
  public function setQuestionHelper(QuestionHelper $question_helper) :void {
    $this->questionHelper = $question_helper;
  }

  /**
   * {@inheritdoc}
   */
  public function title($message) {
    $this->writeln('');
    $this->writeln(' ' . $message);
    $length = Helper::strlenWithoutDecoration($this->getFormatter(), $message);
    $this->writeln(sprintf('<fg=cyan;options=bold>%s</>', str_repeat('–', $length + 2)));
  }

  /**
   * {@inheritdoc}
   */
  public function askQuestion(Question $question) {
    if (!$this->questionHelper) {
      throw new LogicException('Set question helper before asking questions.');
    }
    return $this->questionHelper->ask($this->input, $this, $question);
  }

  /**
   * {@inheritdoc}
   */
  public function listing(array $elements) {
    $elements = array_map(function ($element) {
      return sprintf(' • %s', $element);
    }, $elements);

    $this->writeln($elements);
    $this->newLine();
  }

  /**
   * {@inheritdoc}
   */
  public function text($message) {
    $messages = \is_array($message) ? array_values($message) : [$message];
    foreach ($messages as $message) {
      $this->writeln(sprintf(' <info>%s</info>', $message));
    }
  }

  /**
   * Prints horizontal rule.
   */
  public function rule(int $length = 50) :void {
    $this->writeln(sprintf('<fg=green>%s</>', str_repeat('–', $length)));
  }

}
