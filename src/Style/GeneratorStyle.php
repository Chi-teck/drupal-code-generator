<?php

namespace DrupalCodeGenerator\Style;

use DrupalCodeGenerator\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Output decorator for the DCG style guide.
 */
class GeneratorStyle extends SymfonyStyle implements GeneratorStyleInterface {

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
  public function __construct(InputInterface $input, OutputInterface $output, QuestionHelper $question_helper) {
    $this->input = $input;
    $this->output = $output;
    $this->questionHelper = $question_helper;
    parent::__construct($input, $output);
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
    return $this->questionHelper->ask($this->input, $this, $question);
  }

  /**
   * {@inheritdoc}
   */
  public function listing(array $elements) {
    $build_item = function (string $element): string {
      return sprintf(' • %s', $element);
    };
    $elements = array_map($build_item, $elements);
    $this->writeln($elements);
    $this->newLine();
  }

  /**
   * {@inheritdoc}
   */
  public function text($message) {
    $messages = is_array($message) ? array_values($message) : [$message];
    foreach ($messages as $message) {
      $this->writeln(sprintf(' <info>%s</info>', $message));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildTable(array $headers, array $rows): Table {
    $style = clone Table::getStyleDefinition('symfony-style-guide');
    $style->setCellHeaderFormat('<info>%s</info>');

    $table = new Table($this);
    $table->setHeaders($headers);
    $table->setRows($rows);
    $table->setStyle($style);

    return $table;
  }

}
