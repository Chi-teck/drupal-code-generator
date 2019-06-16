<?php

namespace Drupal\foo\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;

/**
 * Class FooExampleCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="foo",
 *     extensionType="module"
 * )
 */
class FooExampleCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('foo:example')
      ->setDescription('Command description.');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->getIo()->info('It works!');
  }

}
