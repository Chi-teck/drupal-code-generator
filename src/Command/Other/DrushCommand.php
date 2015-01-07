<?php

namespace DrupalCodeGenerator\Command\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Question;


class DrushCommand extends BaseGenerator {

  protected function configure() {
    $this
      ->setName('generate:other:drush-command')
      ->setDescription('Generate Drush command');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $vars_names = [
      'name',
      'description',
    ];
    $vars = $this->collectVars($input, $output, $vars_names, 'Command');

    /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
    $helper = $this->getHelper('question');

    $question = new Question('Command argument', 'foo');
    $vars['argument'] = $helper->ask($input, $output, $question);

    $question = new Question('Command option', 'bar');
    $vars['option'] = $helper->ask($input, $output, $question);

    $question = new Question('File name', $vars['name']);
    $vars['file_name'] = $helper->ask($input, $output, $question);

    $files[$vars['file_name'] . '.drush.inc'] = $this->twig->render('other-drush-command.twig', $vars);

    var_dump($vars);

    $this->submitFiles($input, $output, $files);

  }

}
