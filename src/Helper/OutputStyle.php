<?php

namespace DrupalCodeGenerator\Helper;

use DrupalCodeGenerator\InputAwareInterface;
use DrupalCodeGenerator\InputAwareTrait;
use DrupalCodeGenerator\OutputAwareInterface;
use DrupalCodeGenerator\OutputAwareTrait;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Output decorator for the DCG style guide.
 */
class OutputStyle extends Helper implements OutputInterface, InputAwareInterface, OutputAwareInterface {

  use InputAwareTrait;
  use OutputAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'io';
  }

  /**
   * {@inheritdoc}
   */
  public function title($message) {
    $this->writeln('');
    $this->writeln(' ' . $message);
    $length = self::strlenWithoutDecoration($this->getFormatter(), $message);
    $this->writeln(sprintf('<fg=cyan;options=bold>%s</>', str_repeat('–', $length + 2)));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormatter() {
    return $this->output->getFormatter();
  }

  /**
   * {@inheritdoc}
   */
  public function askQuestion(Question $question) {
    return $this->getHelperSet()->get('question')->ask($this->input, $this, $question);
  }

  /**
   * {@inheritdoc}
   */
  public function listing(array $elements) {
    $build_item = function (string $element) :string {
      return sprintf(' • %s', $element);
    };
    $elements = array_map($build_item, $elements);
    $this->writeln($elements);
    $this->newLine();
  }

  /**
   * {@inheritdoc}
   */
  public function newLine($count = 1) {
    $this->output->write(str_repeat(PHP_EOL, $count));
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
   * Prints horizontal rule.
   */
  public function rule(int $length = 50): void {
    $this->writeln(sprintf('<fg=green>%s</>', str_repeat('–', $length)));
  }

  /**
   * {@inheritdoc}
   */
  public function buildTable(array $headers, array $rows) {
    $style = clone Table::getStyleDefinition('symfony-style-guide');
    $style->setCellHeaderFormat('<info>%s</info>');

    $table = new Table($this);
    $table->setHeaders($headers);
    $table->setRows($rows);
    $table->setStyle($style);

    return $table;
  }

  /**
   * {@inheritdoc}
   */
  public function write($messages, $newline = FALSE, $type = self::OUTPUT_NORMAL) :void {
    $this->output->write($messages, $newline, $type);
  }

  /**
   * {@inheritdoc}
   */
  public function writeln($messages, $type = self::OUTPUT_NORMAL) {
    $this->output->writeln($messages, $type);
  }

  /**
   * {@inheritdoc}
   */
  public function setVerbosity($level) {
    $this->output->setVerbosity($level);
  }

  /**
   * {@inheritdoc}
   */
  public function getVerbosity() :int {
    return $this->output->getVerbosity();
  }

  /**
   * {@inheritdoc}
   */
  public function setDecorated($decorated) :void {
    $this->output->setDecorated($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function isDecorated() :bool {
    return $this->output->isDecorated();
  }

  /**
   * {@inheritdoc}
   */
  public function setFormatter(OutputFormatterInterface $formatter) :void {
    $this->output->setFormatter($formatter);
  }

  /**
   * {@inheritdoc}
   */
  public function isQuiet() :bool {
    return $this->output->isQuiet();
  }

  /**
   * {@inheritdoc}
   */
  public function isVerbose() :bool {
    return $this->output->isVerbose();
  }

  /**
   * {@inheritdoc}
   */
  public function isVeryVerbose() :bool {
    return $this->output->isVeryVerbose();
  }

  /**
   * {@inheritdoc}
   */
  public function isDebug() :bool {
    return $this->output->isDebug();
  }

  /**
   * Returns error output.
   */
  protected function getErrorOutput() :OutputInterface {
    if (!$this->output instanceof ConsoleOutputInterface) {
      return $this->output;
    }
    return $this->output->getErrorOutput();
  }

}
