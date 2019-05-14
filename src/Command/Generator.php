<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Utils;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base class for all generators.
 */
abstract class Generator extends Command implements GeneratorInterface, IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * The command name.
   *
   * @var string
   */
  protected $name;

  /**
   * The command description.
   *
   * @var string
   */
  protected $description;

  /**
   * The command alias.
   *
   * @var string
   */
  protected $alias;

  /**
   * Command label.
   *
   * @var string
   */
  protected $label;

  /**
   * A path where templates are stored.
   *
   * @var string
   */
  protected $templatePath;

  /**
   * The working directory.
   *
   * @var string
   */
  protected $directory;

  /**
   * Assets to create.
   *
   * @var \DrupalCodeGenerator\Asset[]
   */
  protected $assets = [];

  /**
   * Twig template variables.
   *
   * @var array
   */
  protected $vars = [];

  /**
   * {@inheritdoc}
   */
  protected function configure():void {
    $this
      ->setName($this->name)
      ->setDescription($this->description)
      ->addOption(
        'directory',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Working directory'
      )
      ->addOption(
        'answer',
        '-a',
        InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
        'Answer to generator question'
      )
      ->addOption(
        'dry-run',
        NULL,
        InputOption::VALUE_NONE,
        'Output the generated code but not save it to file system'
      );

    if ($this->alias) {
      $this->setAliases([$this->alias]);
    }

    if (!$this->templatePath) {
      $this->templatePath = Application::getRoot() . '/templates';
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output) :void {

    $this->io = new GeneratorStyle($input, $output, $this->getHelper('question'));
    foreach ($this->getHelperSet() as $helper) {
      if ($helper instanceof IOAwareInterface) {
        $helper->io($this->io);
      }
    }

    $this->getHelperSet()->setCommand($this);

    $this->getHelper('renderer')->addPath($this->templatePath);
    $this->setLogger($this->getHelper('logger_factory')->getLogger());

    $this->logger->debug('Command: {command}', ['command' => get_class($this)]);

    $this->io->title(sprintf("Welcome to %s generator!", $this->getName()));

    $this->directory = $input->getOption('directory') ?: getcwd();
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) :int {

    $this->generate();

    $this->logger->debug('Working directory: {directory}', ['directory' => $this->directory]);

    // Render all assets.
    $renderer = $this->getHelper('renderer');

    $this->processVars();

    $collected_vars = preg_replace('/^Array/', '', print_r($this->vars, TRUE));
    $this->logger->debug('Collected variables: {vars}', ['vars' => $collected_vars]);

    foreach ($this->assets as $asset) {
      // Supply the asset with all collected variables if it has no local ones.
      if (!$asset->getVars()) {
        $asset->vars($this->vars);
      }
      $renderer->renderAsset($asset);
      $this->logger->debug('Rendered template: {template}', ['template' => $asset->getTemplate()]);
    }

    $dumped_assets = $this->getHelper('dumper')
      ->dump($this->assets, $this->getDestination(), $input->getOption('dry-run'));

    $this->getHelper('result_printer')->printResult($dumped_assets);

    $this->logger->debug('Memory usage: {memory}', ['memory' => Helper::formatMemory(memory_get_peak_usage())]);
    return 0;
  }

  /**
   * Generates assets.
   */
  abstract protected function generate() :void;

  /**
   * {@inheritdoc}
   */
  public function getLabel() :?string {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setDirectory(string $directory) :void {
    $this->directory = $directory;
  }

  /**
   * {@inheritdoc}
   */
  public function getDirectory() :string {
    return $this->directory;
  }

  /**
   * Asks a question.
   */
  protected function ask(string $question, $default = NULL, $validator = NULL) {
    $this->processVars();
    $question = Utils::replaceTokens($question, $this->vars);
    $default = Utils::replaceTokens($default, $this->vars);
    return $this->io->ask($question, $default, $validator);
  }

  /**
   * Asks for confirmation.
   */
  protected function confirm(string $question, bool $default = TRUE) :bool {
    $this->processVars();
    $question = Utils::replaceTokens($question, $this->vars);
    return $this->io->confirm($question, $default);
  }

  /**
   * Asks a choice question.
   */
  protected function choice(string $question, array $choices, $default = NULL) {
    $this->processVars();
    $question = Utils::replaceTokens($question, $this->vars);

    // The choices can be an associative array.
    $choice_labels = array_values($choices);
    // Start choices list form '1'.
    array_unshift($choice_labels, NULL);
    unset($choice_labels[0]);

    // Do not use IO choice here as it prints choice key as default value.
    // @see \Symfony\Component\Console\Style\SymfonyStyle::choice().
    $answer = $this->io->askQuestion(new ChoiceQuestion($question, $choice_labels, $default));
    return array_search($answer, $choices);
  }

  /**
   * Creates an asset.
   *
   * @param string $type
   *   Asset type.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addAsset(string $type) :Asset {
    $asset = (new Asset())->type($type);
    $this->assets[] = $asset;
    return $asset;
  }

  /**
   * Creates file asset.
   *
   * @param string $path
   *   (Optional) File path.
   * @param string $template
   *   (Optional) Template.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addFile(string $path = NULL, string $template = NULL) :Asset {
    return $this->addAsset('file')
      ->path($path)
      ->template($template);
  }

  /**
   * Creates directory asset.
   *
   * @param string $path
   *   (Optional) Directory path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addDirectory(string $path = NULL) :Asset {
    return $this->addAsset('directory')->path($path);
  }

  /**
   * Processes collected variables.
   */
  protected function processVars() :void {
    array_walk_recursive($this->vars, function (&$var, string $key, array $vars) :void {
      if (is_string($var)) {
        $var = Utils::replaceTokens($var, $vars);
      }
    }, $this->vars);
  }

  /**
   * Returns destination for generated files.
   */
  protected function getDestination() {
    return $this->directory;
  }

}
