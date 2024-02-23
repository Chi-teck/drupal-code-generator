<?php

declare(strict_types=1);

namespace Drupal\foo\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// phpcs:disable Drupal.Commenting.ClassComment.Missing
#[AsCommand(
  name: 'bar',
  description: 'Bar command.',
  aliases: ['bar'],
)]
final class BarCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    // @todo Place your code here.
    $output->writeln('<info>It works!</info>');
    return self::SUCCESS;
  }

}
