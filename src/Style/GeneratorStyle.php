<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Style;

use DrupalCodeGenerator\Compatibility\AskQuestionTrait;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Output decorator for the DCG style guide.
 */
final class GeneratorStyle extends SymfonyStyle implements GeneratorStyleInterface {
  use AskQuestionTrait;

  /**
   * Console input.
   */
  private InputInterface $input;

  /**
   * Console output.
   */
  private OutputInterface $output;

  /**
   * Question helper.
   */
  private QuestionHelper $questionHelper;

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
  public function title($message): void {
    $this->writeln('');
    $this->writeln(' ' . $message);
    if (\method_exists('\Symfony\Component\Console\Helper\Helper', 'width')) {
      $length = Helper::width(Helper::removeDecoration($this->getFormatter(), $message));
    }
    else {
      $length = Helper::strlenWithoutDecoration($this->getFormatter(), $message);
    }
    $this->writeln(\sprintf('<fg=cyan;options=bold>%s</>', \str_repeat('–', $length + 2)));
  }

  /**
   * {@inheritdoc}
   */
  protected function compatAskQuestion(Question $question) {
    $answer = $this->questionHelper->ask($this->input, $this, $question);
    if (\is_string($answer)) {
      $answer = Utils::addSlashes($answer);
    }
    return $answer;
  }

  /**
   * {@inheritdoc}
   */
  public function listing(array $elements): void {
    $build_item = static fn (string $element): string => \sprintf(' • %s', $element);
    $elements = \array_map($build_item, $elements);
    $this->writeln($elements);
    $this->newLine();
  }

  /**
   * {@inheritdoc}
   */
  public function text($message): void {
    $messages = \is_array($message) ? \array_values($message) : [$message];
    foreach ($messages as $message) {
      $this->writeln(\sprintf(' <info>%s</info>', $message));
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

  /**
   * {@inheritdoc}
   */
  public function getInput(): InputInterface {
    return $this->input;
  }

  /**
   * {@inheritdoc}
   */
  public function getOutput(): OutputInterface {
    return $this->output;
  }

  /**
   * {@inheritdoc}
   */
  public function getErrorStyle(): self {
    return new self($this->input, $this->getErrorOutput(), $this->questionHelper);
  }

}
