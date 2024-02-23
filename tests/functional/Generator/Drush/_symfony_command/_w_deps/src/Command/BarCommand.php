<?php

declare(strict_types=1);

namespace Drupal\foo\Command;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// phpcs:disable Drupal.Commenting.ClassComment.Missing
#[AsCommand(
  name: 'foo:bar',
  description: 'Example command.',
  aliases: ['bar'],
)]
final class BarCommand extends Command {

  /**
   * Constructs a BarCommand object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    // @todo Place your code here.
    $output->writeln('<info>It works!</info>');
    return self::SUCCESS;
  }

}
