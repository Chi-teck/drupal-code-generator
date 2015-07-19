<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Implementation of generate command.
 */
class Generate extends Command {

  protected $name = 'generate';
  protected $description = 'Generate code';
  protected $activeMenuItems = [];
  protected $menuTree =  [
    'Drupal 8' => [
      'Module',
      'Theme',
      'Installation profile',
      'Component' => [
        'Plugin' => [
          'Filter',
          'FieldType',
          'Block',
        ],
        'YML file' => [
          'libraries.yml',
          'routing.yml',
          'services.yml'
        ]
      ],
    ],
    'Drupal 7' => [
      'Module',
      'Theme',
      'Installation profile',
      'Component' => [
        'settings.php',
        'Info file',
        'Install file',
        'Module file',
        'Js file',
        'Views' => [],
        'CTools Plugin' => [
          'Content type',
        ],
      ],
    ],
    'Drupal 6' => [
      'Module',
      'Theme',
      'Installation profile',
      'Component' => [
        'Info file',
      ],
    ],
    'Other' => [
      'Drush command',
      'Apache virtual host',
    ]
  ];


  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName($this->name)
      ->setDescription($this->description);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    /** @var \DrupalCodeGenerator\Commands\BaseGenerator $generator */
    $generator = $this->selectGenerator($input, $output);

    try {
      $command = $this->getApplication()->find($generator);
    }
    catch(\InvalidArgumentException $e) {
      $output->writeLn("<error>Sorry command $generator is not implemented yet.</error>");
      exit(1);
    }

    $output->writeln(sprintf('<info>Command:</info> <comment>%s</comment>', $command->getName()));
    $output->writeLn(str_repeat('<comment>-</comment>', 35));

    $command->run($input, $output);
  }

  /**
   *
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output) {

    // Find active subtree;
    $activeTree = $this->menuTree;
    foreach ($this->activeMenuItems as $menu_item) {
      $menu_item = strip_tags($menu_item);
      $activeTree = isset($activeTree[$menu_item]) ? $activeTree[$menu_item] : [];
    }

    foreach ($activeTree as $index => $subtree) {
      $menu[] = is_array($subtree) ? $index : "<comment>$subtree</comment>";
    }

    if (isset($menu)) {

      // Zero key is used to move back into the parent menu item.
      array_unshift($menu, '..');
      if (!$this->activeMenuItems) {
        unset($menu[0]);
      }

      $question = new ChoiceQuestion(
        '<title>Select generator:</title>',
        $menu
      );

      $answer = $this->getHelper('question')->ask($input, $output, $question);

      if ($answer == '..') {
        array_pop($this->activeMenuItems);
      }
      else {
        $this->activeMenuItems[] = $answer;
      }

      return $this->selectGenerator($input, $output);
    }
    else {
      $generator = strip_tags(implode(':', $this->activeMenuItems));
      $generator = strtolower($generator);
      $generator = str_replace('drupal ', 'd', $generator);
      $generator = str_replace(' ', '-', $generator);
      return 'generate:' . $generator;
    }

  }

}
