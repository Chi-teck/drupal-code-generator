<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\InputOutput;

use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\StyleInterface as SymfonyStyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * The Input/Output helper.
 */
final class IO extends SymfonyStyle implements SymfonyStyleInterface, OutputInterface {

  /**
   * IO constructor.
   */
  public function __construct(
    private readonly InputInterface $input,
    private readonly OutputInterface $output,
    private readonly QuestionHelper $questionHelper,
  ) {
    parent::__construct($input, $output);
  }

  /**
   * {@inheritdoc}
   */
  public function title(string $message): void {
    $this->newLine();
    $this->writeln(' ' . $message);
    $length = Helper::width(Helper::removeDecoration($this->getFormatter(), $message));
    $this->writeln(\sprintf('<fg=cyan;options=bold>%s</>', \str_repeat('–', $length + 2)));
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  public function askQuestion(Question $question): mixed {
    $answer = $this->questionHelper->ask($this->input, $this, $question);
    if (\is_string($answer)) {
      $answer = Utils::addSlashes($answer);
    }
    return $answer;
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  public function listing(array $elements): void {
    $build_item = static fn (string $element): string => \sprintf(' • %s', $element);
    $elements = \array_map($build_item, $elements);
    $this->writeln($elements);
    $this->newLine();
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-param non-empty-list<non-empty-list<string>> $headers
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
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  public function getErrorStyle(): self {
    return new self($this->input, $this->getErrorOutput(), $this->questionHelper);
  }

  /**
   * Returns current working directory.
   *
   * Can be helpful to supply generators with some context. For instance, the
   * directory name can be used to set default extension name.
   */
  public function getWorkingDirectory(): string {
    // $_SERVER['PWD'] takes precedence over getcwd() as it does not mutate
    // during bootstrap process.
    // @todo Make the working dir absolute.
    // phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
    return $this->getInput()->getOption('working-dir') ?? $_SERVER['PWD'] ?? \getcwd();
  }

}
