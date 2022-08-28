<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements generate-completion command.
 */
final class GenerateCompletion extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {
    parent::configure();
    $this
      ->setName('generate-completion')
      ->setDescription('Generates shell completion for DCG')
      ->addUsage('--shell=bash >> ~/.bash_completion')
      ->addOption('shell', NULL, InputOption::VALUE_OPTIONAL, 'Shell type', 'bash');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $shell = $input->getOption('shell');
    if (!\in_array($shell, ['bash', 'fish', 'zsh'])) {
      $message = \sprintf('<error>Shell "%s" is not supported.</error>', \strip_tags($shell));
      /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
      $output->getErrorOutput()->writeln($message);
      return self::FAILURE;
    }
    // The completions need to be re-generated each time the command set is
    // updated.
    // @see https://github.com/bamarni/symfony-console-autocomplete
    $content = \file_get_contents(Application::ROOT . "/resources/$shell-completion");
    $output->writeln($content, OutputInterface::OUTPUT_RAW);
    return self::SUCCESS;
  }

}
